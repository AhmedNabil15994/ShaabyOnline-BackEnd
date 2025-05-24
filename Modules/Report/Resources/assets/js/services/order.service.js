const resource = 'orders'
export default {
  create(data){
    return axios.post(`${resource}/create-cashier`, data)
  }
  
}
