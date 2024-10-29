import axios from 'axios'

export default class CustomerService {

    getCustomersLarge() {
		return axios.get('assets/data/customers-large.json').then(res => res.data.data);
    }

}
