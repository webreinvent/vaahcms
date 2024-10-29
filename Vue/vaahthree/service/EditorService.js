import axios from 'axios'

export default class EditorService {

	getEditor(theme) {
		return axios.get('editor/' + theme + '.json').then(res => res.data.editor);
	}
}