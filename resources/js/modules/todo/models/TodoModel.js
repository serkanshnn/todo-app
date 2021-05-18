import {merge} from "lodash";

class TodoModel {
    constructor(params) {
        return merge({
            id: '',
            title: '',
            description: '',
            is_active: false
        },params);
    }
}
export default TodoModel;
