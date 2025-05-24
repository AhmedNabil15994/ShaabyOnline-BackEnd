const resource = 'catalog/products'
export default {

  list (params) {
    return axios.get(`${resource}`, {
      params
    })
  },
  
}
