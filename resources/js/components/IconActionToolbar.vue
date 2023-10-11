<template>

    <div v-if="actions.length > 0"
         :class="{ 'rounded': standalone, 'rounded-lg bg-gray-100 dark:bg-gray-700': !standalone }"
         class="flex ml-1 dark:focus:ring-gray-600 justify-evenly">

        <div v-for="action of actions">

            <Dropdown
                v-tooltip="action.name"
                :handle-internal-clicks="false"
                :class="{
                    'rounded hover:bg-gray-200 dark:hover:bg-gray-800': standalone,
                    'rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700': !standalone,
                    'hover:text-red-500': action.destructive,
                    'hover:text-primary-500': !action.destructive,
                }"
                class="flex h-9"
                :trigger-override-function="() => $emit('click', action.uriKey)">

                <div :class="{ 'px-3 h-9 flex justify-center items-center': standalone, 'px-2': !standalone }">

                    <template v-if="action.icon.trim().startsWith('<svg')">
                        <div v-html="action.icon"/>
                    </template>

                    <Icon v-else :type="action.icon"/>

                </div>

            </Dropdown>

        </div>

    </div>

</template>

<script>

    export default {
        emits: [ 'click' ],
        props: [ 'actions', 'standalone' ],
    }

</script>
