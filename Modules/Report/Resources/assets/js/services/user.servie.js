
export default {

  updateProfile(url,data){
    return axios.post(url, data)
  },
  listUsers(data){
    return axios.get("users/list", {
      params:data
    })
  }

  
}
