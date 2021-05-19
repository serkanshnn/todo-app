import axios from "axios";

export const all = () => {
    return axios.get(`/api/todos`);
};

export const detail = (id) => {
    return axios.get(`/api/todos/${id}`);
};

export const checkOrUncheck = (id) => {
    return axios.post(`/api/todos/${id}/check`);
}
