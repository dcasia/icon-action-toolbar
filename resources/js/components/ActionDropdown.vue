<template>

  <div class="icon-action-toolbar">

    <!-- Confirm Action Modal -->
    <component
        v-if="actionModalVisible"
        :show="actionModalVisible"
        class="text-left"
        :is="selectedAction?.component"
        :working="working"
        :selected-resources="selectedResources"
        :resource-name="resourceName"
        :action="selectedAction"
        :errors="errors"
        @confirm="runAction"
        @close="closeConfirmationModal"/>

    <component
        v-if="responseModalVisible"
        :show="responseModalVisible"
        :is="actionResponseData?.modal"
        @confirm="handleResponseModalDismiss"
        @close="handleResponseModalDismiss"
        :data="actionResponseData"/>

  </div>

  <IconActionToolbar
      :parent-type="parentType"
      :actions="availableActions"
      @click="onClick"
      :standalone="true"/>

  <div v-if="dropdownActions.length > 0" style="order: 99">
  <Dropdown>
    <template #default>
      <button
          v-tooltip="'Actions'"
          type="button"
          class="inline-flex items-center justify-center h-9 w-9 dark:text-gray-400 text-gray-500 hover:[&:not(:disabled)]:text-primary-500 dark:hover:[&:not(:disabled)]:text-primary-500">
        <Icon name="ellipsis-horizontal"/>
      </button>
    </template>
    <template #menu>
      <DropdownMenu width="auto">
        <div class="py-1">
          <DropdownMenuItem
              v-for="action in dropdownActions"
              :key="action.uriKey"
              as="button"
              class="border-none"
              @click="onClick(action.uriKey)"
          >
            {{ action.name }}
          </DropdownMenuItem>
        </div>
      </DropdownMenu>
    </template>
  </Dropdown>
  </div>

</template>

<script setup>

import {useActions} from '@/composables/useActions'
import {useLocalization} from '@/composables/useLocalization'
import {useNovaPage} from '../composables/useNovaPage'
import {Icon} from 'laravel-nova-ui'
import IconActionToolbar from './IconActionToolbar.vue'
import {computed, getCurrentInstance} from 'vue'

const emitter = defineEmits(['actionExecuted', 'show-preview'])

const props = defineProps({
  resourceName: {},
  viaResource: {},
  viaResourceId: {},
  viaRelationship: {},
  relationshipType: {},
  actions: {type: Array, default: []},
  selectedResources: {type: [Array, String], default: () => []},
  endpoint: {type: String, default: null},
  triggerDuskAttribute: {type: String, default: null},
})

const {
  errors,
  actionModalVisible,
  responseModalVisible,
  closeConfirmationModal,
  closeResponseModal,
  handleActionClick,
  selectedAction,
  working,
  executeAction,
  actionResponseData,
} = useActions(props, emitter, Nova.store)

const {__} = useLocalization()
const instance = getCurrentInstance()

const runAction = () => executeAction(() => emitter('actionExecuted'))
const {isDetailPage} = useNovaPage()

// parentType identifies which Nova component hosts this ActionDropdown.
// __file is available in dev builds but stripped in production; name may also be absent
// for anonymous SFCs. The fallback infers context from the Inertia page type.
const parentType = computed(() => {
  const parent = instance.parent
  const raw = parent?.vnode?.type?.__file || parent?.vnode?.type?.name
  const name = raw?.split('/')?.pop()?.replace('.vue', '') ?? null
  if (name) return name
  return isDetailPage.value ? 'DetailActionDropdown' : 'InlineActionDropdown'
})

const onClick = event => {
  const action = availableActions.value.find(element => element.uriKey === event)

  if (!action) return

  if (typeof action.onClick === 'function') {
    action.onClick()
  } else {
    handleActionClick(event)
  }
}

const handleResponseModalDismiss = () => {
  closeResponseModal()
  emitter('actionExecuted')
}

const availableActions = computed(() => {

  const actions = [...props.actions]
  const resource = instance.parent?.props?.resource
  const currentUser = Nova.store.getters['currentUser']
  const config = Nova.config('icon_action_toolbar')
  const isViaManyToMany = instance.parent?.props?.viaManyToMany === true

  if (resource && isViaManyToMany === false) {

    if (resource.authorizedToReplicate) {

      actions.push({
        name: __('Replicate'),
        uriKey: '__replicate-action__',
        iconActionToolbar: {icon: config.icons.replicate},
        onClick: () => {

          const url = instance.ctx.$url(`/resources/${props.resourceName}/${resource.id.value}/replicate`, {
            viaResource: props.viaResource,
            viaResourceId: props.viaResourceId,
            viaRelationship: props.viaRelationship,
          }).replace(Nova.config('base'), '')

          Nova.visit(url)
        },
      })
    }

    if (resource.authorizedToView && resource.previewHasFields) {

      actions.push({
        name: __('Preview'),
        uriKey: '__preview-action__',
        iconActionToolbar: {icon: config.icons.preview},
        onClick: () => instance.parent.emit('show-preview'),
      })
    }

    if (currentUser?.canImpersonate && resource.authorizedToImpersonate) {

      actions.push({
        name: __('Impersonate'),
        uriKey: '__impersonate-action__',
        iconActionToolbar: {icon: config.icons.impersonate},
        onClick: () => instance.parent.ctx.startImpersonating({
          resource: props.resourceName,
          resourceId: resource.id.value,
        }),
      })
    }

    if (resource.authorizedToDelete
        && !resource.softDeleted
        && isDetailPage.value
        && props.selectedResources.length === 1
        && (props.selectedResources[0] === props.viaResourceId || props.viaResourceId === undefined)) {
      actions.push({
        name: __('Delete Resource'),
        uriKey: '__delete-resource-action__',
        iconActionToolbar: {icon: config.icons.delete_resource},
        onClick: () => instance.parent.ctx.openDeleteModal(),
      })
    }
  }

  return actions
})

const dropdownActions = computed(() => availableActions.value.filter(a => !a.iconActionToolbar))

</script>
