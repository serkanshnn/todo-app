<template>
    <div>
        <div class="w-3/5 mx-auto mt-12">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class=" px-4 py-5 -ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                    <div class="ml-4 mt-2">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Todo #{{model.id}}
                        </h3>
                    </div>
                    <div class="ml-4 mt-2 flex-shrink-0">
                        <a href="/todos" class="relative inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Back
                        </a>
                        <a :href="'/todos/'+model.id+'/edit'" class="relative inline-flex items-center px-4 py-2 ml-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Edit
                        </a>
                    </div>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Title
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ model.title }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Description
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ model.description }}
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Status
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"  :class="model.is_active ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'">
                                  {{ status }}
                                </span>
                                <a href="#" @click="handleCheckStatus" :class="model.is_active ? 'text-yellow-600 hover:text-yellow-900' : 'text-green-600 hover:text-green-900'" class="p-3">{{ getCheckButtonLabel }}</a>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TodoModel from "../models/TodoModel";
import TodoStore from "../store/TodoStore";

export default {
    name: "TodoPage",
    props: ['data'],
    data() {
        return {
            model: {},
            payload: {}
        }
    },
    mounted() {
        this.handleFetchTodoDetail();
        this.handleModel(this.data);
    },
    methods: {
        handleModel(payload) {
            console.log(payload);
            this.model = new TodoModel();
            this.model.id = payload.id;
            this.model.title = payload.title;
            this.model.description = payload.description;
            this.model.is_active = payload.is_active;
        },
        handleFetchTodoDetail() {
            TodoStore.fetchTodoDetail(this.data.id)
                .then(response => {
                    this.payload = response.data.data;
                })
                .catch((error) => {
                    console.log(error);
                }).finally(() => {
                    this.handleModel(this.payload);
                });
        },
        handleCheckStatus() {
            TodoStore.checkOrUncheck(this.data.id)
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => {
                    this.handleFetchTodoDetail()
                });
        }
    },
    computed: {
        status() {
            if (this.model.is_active) {
                return "Done";
            }
            return "In progress";
        },
        getCheckButtonLabel() {
            if (this.model.is_active) {
                return "Uncheck";
            }
            return "Check";
        }
    }
}
</script>

<style scoped>

</style>
