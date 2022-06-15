import axios from "axios"
axios.defaults.baseURL = `/admin`
const api = {
  getRole: (payload) => axios.post('/role/listing', payload),
  storeRole: (payload) => axios.post('/role/add', payload),
  deleteRole: (id) => axios.post(`role/${id}/delete`) 
}
export default {
  install: (app, options) => {
    app.config.globalProperties.$api = api
  }
}
  