import { Inertia } from '@inertiajs/inertia'
import { computed } from 'vue'

export function useNovaPage() {
  const pageComponent = computed(() => Inertia.page?.component ?? '')
  const isDetailPage = computed(() => pageComponent.value === 'Nova.Detail')
  const isIndexPage = computed(() =>
    pageComponent.value === 'Nova.Index' || pageComponent.value === 'Nova.Lens'
  )
  return { pageComponent, isDetailPage, isIndexPage }
}
