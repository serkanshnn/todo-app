<template>
    <div>
        <div class="rounded-md p-4 mb-5" :class="type === 'error' ? 'bg-red-50' : 'bg-green-50'">
            <div class="flex">
                <div class="flex-shrink-0">
                    <!-- Heroicon name: solid/x-circle -->
                    <svg class="h-5 w-5" :class="type === 'error' ? 'text-red-400' : 'text-green-400'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" v-html="getSvg">
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium" :class="type === 'error' ? 'text-red-800' : 'text-green-800'">
                        {{ getContent }}
                    </h3>
                    <div class="mt-2 text-sm text-red-700" v-show="type === 'error'">
                        <ul class="list-disc pl-5 space-y-1">
                            <li v-for="error in data">
                                {{ error[0] }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Alert",
    props: ['type', 'data'],
    computed: {
        errorCount() {
            return Object.keys(this.data).length;
        },
        getContent() {
            if (this.type === 'error') {
                return  "There were "+Object.keys(this.data).length+" errors with your submission"
            }
            return 'Todo successfully created.'
        },
        getSvg() {
            if (this.type === 'error') {
                return `<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />`;
            }
            return `<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />`
        }
    }
}
</script>

<style scoped>

</style>
