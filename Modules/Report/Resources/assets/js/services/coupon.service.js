const resource = 'coupons'
export default {


  applyCoupon(data){
    return axios.post(`${resource}/check_coupon`, data)
  }
  
}
