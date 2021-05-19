<template>
    <tr :class="getRowBackground">
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
            {{ numberOfTodo }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
            {{ model.title }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ model.description }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"  :class="model.is_active ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'">
              {{ status }}
            </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
            <a href="#" @click="handleCheckStatus" :class="model.is_active ? 'text-yellow-600 hover:text-yellow-900' : 'text-green-600 hover:text-green-900'" class="p-3">{{ getCheckButtonLabel }}</a>
            <a :href="'/todos/'+this.model.id" class="text-blue-600 hover:text-blue-900 p-3">Detail</a>
            <a href="#" @click="handleDeleteTodo" class="text-red-600 hover:text-red-900 p-3">Delete</a>
        </td>
    </tr>
</template>

<script>
import TodoModel from "../models/TodoModel";
import TodoStore from "../store/TodoStore";

export default {
    name: "Todo",
    props: ['index', 'todo'],
    data() {
        return {
            model: {}
        }
    },
    mounted() {
        this.handleModel();
    },
    methods: {
        handleModel() {
          this.model = new TodoModel();
          this.model.id = this.todo.id;
          this.model.title = this.todo.title;
          this.model.description = this.todo.description;
          this.model.is_active = this.todo.is_active;
        },
        handleCheckStatus() {
          TodoStore.checkOrUncheck(this.model.id)
              .catch((error) => {
                  console.log(error);
              })
              .finally(() => {
                  this.$emit('fetch-todos')
              });
        },
        handleDeleteTodo() {
            TodoStore.deleteTodo(this.model.id)
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => {
                    this.$emit('fetch-todos')
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
        numberOfTodo() {
            return this.index + 1;
        },
        getCheckButtonLabel() {
            if (this.model.is_active) {
                return "Uncheck";
            }
            return "Check";
        },
        getRowBackground() {
            if (this.index % 2) {
                return "bg-gray-50";
            }
            return "bg-white";
        }
    },
    watch: {
        todo: function () {
            this.handleModel();
        }
    }
}
</script>

<style scoped>

</style>
