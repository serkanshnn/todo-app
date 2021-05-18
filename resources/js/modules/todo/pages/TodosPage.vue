<template>
    <div>
        <div class="w-full">
            <div class="flex flex-col w-3/5 mx-auto mt-4">
                <h1 class="text-2xl font-bold leading-7 text-gray-700 sm:text-3xl sm:truncate mx-auto mb-4">TODOS</h1>
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Title
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Description
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Detail</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <!-- Odd row -->
                                <!-- Even: bg-gray-50-->
                                    <Todo
                                        v-for="(todo, index) in payload"
                                        :key="todo.id"
                                        :index="index"
                                        :todo="todo"
                                        @fetch-todos="handleFetchTodos"
                                    />
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TodoStore from "../store/TodoStore";
import Todo from "../components/Todo";
export default {
    name: "TodosPage",
    data() {
        return {
            payload: []
        }
    },
    components: {
        Todo
    },
    methods: {
        handleFetchTodos() {
            TodoStore.fetchAllTodos()
                .then((response) => {
                    this.payload = response.data.data
                })
                .catch(error => console.log(error));
        }
    },
    mounted() {
        this.handleFetchTodos();
    }
}
</script>

<style scoped>

</style>
