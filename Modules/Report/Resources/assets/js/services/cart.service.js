const resource = 'cart'
export default {

  addToCart (data) {
    return axios.post(`${resource}/add-or-update`, data)
  },

  current(user_token){

    return axios.get(`${resource}`, {
        params: {user_token}
    })

  },

  handleDraft(user_token){

    return axios.get(`${resource}/handle-draft`, {
        params: {user_token}
    })

  },

  replaceCart(data){

    return axios.post(`${resource}/repalce-cart`, data)

  },

  removeItem(id, data){
    // console.log(data)
    return axios.post(`${resource}/remove/${id}`, data)

  },
  deleteCondtion(name,data){
    return axios.post(`${resource}/remove-condition/${name}`,data)
  },

  deleteCarts(data){
    return axios.post(`${resource}/clear`,data)
  }
  
}
