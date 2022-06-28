import axios from "axios"

axios.defaults.baseURL = '/admin/';

const api = {
  get: (model, payload) => axios.post(`${model}/listing`, payload),
  store: (model, payload) => axios.post(`${model}/add`, payload),
  delete: (model, id) => axios.post(`${model}/${id}/delete`),
}

export default {
  install: (app) => {
    app.config.globalProperties.$api = api
  }
}
