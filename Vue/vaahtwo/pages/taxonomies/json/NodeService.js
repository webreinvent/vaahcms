export default class NodeService {

    getTreeNodes() {
        return fetch('backend/vaah/manage/taxonomies/test.json').then(res => res.json())
            .then(d => d.root);
    }

}
