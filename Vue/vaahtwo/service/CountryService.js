import axios from 'axios'

export default class CountryService {

	getCountries() {
		return axios.get('assets/data/countries.json').then(res => res.data.data);
	}
}
