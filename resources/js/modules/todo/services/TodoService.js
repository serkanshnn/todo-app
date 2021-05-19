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

export const create = (params) => {
    return axios.post(`/api/todos`, params);
}

export const destroy = (id) => {
    return axios.delete(`/api/todos/${id}`);
}

export const update = (id, params) => {
    return axios.put(`/api/todos/${id}`, params);
}
