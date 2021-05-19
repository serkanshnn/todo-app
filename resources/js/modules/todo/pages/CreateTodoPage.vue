<template>
    <div>
        <div class="w-3/5 mx-auto mt-12">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg p-5">
                <alert :type="alertType" :data="alertData" v-show="hasAlert" />
                <form class="space-y-8 divide-y divide-gray-200" method="POST" @submit.prevent="handleCreateTodo">
                    <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
                        <div>
                            <div>
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Create new todo
                                </h3>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="first_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                Title
                            </label>
                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <input type="text" name="first_name" id="first_name" v-model="title" autocomplete="given-name" class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="about" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                Description
                            </label>
                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <textarea id="about" name="about" rows="3" v-model="description" class="max-w-lg shadow-sm block w-full focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="pt-5">
                        <div class="flex justify-end">
                            <a href="/todos" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </a>
                            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import TodoStore from "../store/TodoStore";
import Alert from "../../../components/Alert";

export default {
    name: "CreateTodoPage",
    components: {
        Alert
    },
    data() {
        return {
            title: '',
            description: '',
            alertData: '',
            alertType: '',
            hasAlert: false,
        }
    },
    methods: {
        handleCreateTodo() {
            TodoStore.createTodo({
                title: this.title,
                description: this.description,
                is_active: false
            }).then(response => {
                if (response.status === 201) {
                    this.alertType = 'success';
                    this.alertData = {};
                    this.hasAlert = true;
                    this.title = '';
                    this.description = '';
                }
            })
            .catch((error) => {
                if(error.response.status === 412) {
                    this.hasAlert = true;
                    this.alertType = 'error';
                    this.alertData = error.response.data.data;
                }
            });
        }
    }
}
</script>

<style scoped>

</style>
