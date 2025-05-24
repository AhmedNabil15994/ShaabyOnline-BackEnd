const resource = 'catalog'
export default {

  list () {
    return axios.get(`${resource}/all-brands`)
  },
  
}
