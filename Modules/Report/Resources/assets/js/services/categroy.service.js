const resource = 'catalog'
export default {

  getMianCategory () {
    return axios.get(`${resource}/all-categories?with_sub_categories=yes`)
  },
  
}
