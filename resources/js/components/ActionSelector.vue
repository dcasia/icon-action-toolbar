<template>

    <div class="icon-action-toolbar w-full">

        <IconActionToolbar
            :actions="actionsForSelect"
            @click="handleSelectionChange"
            :standalone="false"
            parent-type="ActionSelector"/>

        <!-- Confirm Action Modal -->
        <component
            class="text-left"
            v-if="actionModalVisible"
            :show="actionModalVisible"
            :is="selectedAction?.component"
            :working="working"
            :selected-resources="selectedResources"
            :resource-name="resourceName"
            :action="selectedAction"
            :errors="errors"
            @confirm="executeAction"
            @close="closeConfirmationModal"
        />

        <component
            v-if="responseModalVisible"
            :show="responseModalVisible"
            :is="actionResponseData?.modal"
            @confirm="closeResponseModal"
            @close="closeResponseModal"
            :data="actionResponseData"
        />

    </div>

</template>

<script setup>

    import { useActions } from '@/composables/useActions'
    import { computed, ref } from 'vue'
    import IconActionToolbar from './IconActionToolbar.vue'

    // Elements
    const actionSelectControl = ref(null)
    const emitter = defineEmits([ 'actionExecuted' ])

    const props = defineProps({
        width: { type: String, default: 'auto' },
        pivotName: { type: String, default: null },
        resourceName: {},
        viaResource: {},
        viaResourceId: {},
        viaRelationship: {},
        relationshipType: {},
        pivotActions: { type: Object, default: () => ({ name: 'Pivot', actions: [] }) },
        actions: { type: Array, default: [] },
        selectedResources: { type: [ Array, String ], default: () => [] },
        endpoint: { type: String, default: null },
        triggerDuskAttribute: { type: String, default: null },
    })

    const {
        errors,
        actionModalVisible,
        responseModalVisible,
        openConfirmationModal,
        closeConfirmationModal,
        closeResponseModal,
        handleActionClick,
        selectedAction,
        setSelectedActionKey,
        determineActionStrategy,
        working,
        executeAction,
        availableActions,
        availablePivotActions,
        actionResponseData,
    } = useActions(props, emitter, Nova.store)

    const handleSelectionChange = event => {
        setSelectedActionKey(event)
        determineActionStrategy()
    }

    const actionsForSelect = computed(() => {

        const actions = [
            ...availableActions.value,
            ...availablePivotActions.value.map(a => ({
                group: props.pivotName,
                uriKey: a.uriKey,
                name: a.name,
            })),
        ]

        return actions.filter(action => action.showOnTableRow === false)

    })

</script>
