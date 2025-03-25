import ActionSelector from './components/ActionSelector.vue'
import ActionDropdown from './components/ActionDropdown.vue'

Nova.booting(app => {
    app.component('ActionSelector', ActionSelector)
    app.component('ActionDropdown', ActionDropdown)
})
