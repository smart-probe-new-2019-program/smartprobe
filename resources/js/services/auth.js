import Ls from './ls'

export default {
  async login (loginData) {
    try {
      let response = await axios.post('/api/auth/login', loginData)

	  //Set user token
	  Ls.set('auth.token', response.data.token)
	  //Set user id
	  Ls.set('user.id', response.data.user.id)
	  //Set user first name
	  Ls.set('user.first_name', response.data.user.first_name)
	  //Set user last name
	  Ls.set('user.last_name', response.data.user.last_name)
	  //Set user role
	  Ls.set('user.role', response.data.user.role)
	  //Set organization id
	  Ls.set('user.organization_id', response.data.user.organization_id)
	  //Set location id
	  Ls.set('user.location_id', response.data.user.location_id)


      toastr['success']('Logged In!', 'Success')
      return response.data.token
    } catch (error) {
      if (error.response.status === 401) {
        toastr['error']('Invalid Credentials', 'Error')
      } else {
        // Something happened in setting up the request that triggered an Error
        console.log('Error', error.message)
      }
    }
  },

  async logout () {
    try {
	  await axios.get('/api/auth/logout')
	  //Unset user data
	  Ls.remove('auth.token')
	  Ls.remove('user.id')
	  Ls.remove('user.first_name')
	  Ls.remove('user.last_name')
	  Ls.remove('user.role')
	  Ls.remove('user.organization_id')
	  Ls.remove('user.location_id')
      toastr['success']('Logged out!', 'Success')
    } catch (error) {
      console.log('Error', error.message)
    }
  },

  async check () {
    let response = await axios.get('/api/auth/check')

    return !!response.data.authenticated
  }
}
