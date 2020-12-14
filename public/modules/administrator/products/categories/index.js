let totalPrev = 0;
const search = () =>{
    const searchName = document.querySelector('.page-content').querySelector('.form-search').querySelector('[name="name"]').value;
    const limit = document.querySelector('.page-content').querySelector('.form-pagging').querySelector('[name="limit"]').value;
    const page = document.querySelector('.page-content').querySelector('.form-pagging').querySelector('[name="page"]').value;
    axios.get(`${baseApi}/v1/products/categories?name=${searchName}&limit=${limit}&page=${page}`, config).then(res=>{
        const templateClones = document.querySelector('#table-data').querySelectorAll('[data-template="item-cloned"]')
        if(templateClones.length){
            templateClones.forEach(el=>el.remove());
        }
        if(res.data.data.error){
            Toastify({
                text: `${res.data.data.error}`,
                backgroundColor: "red",
                className: "block",
              }).showToast();
        }else if(res.data.data.data.length > 0){         
            const total = res.data.data.total/limit;
            if(totalPrev !== total){
                const elPage = document.querySelector('.page-content').querySelector('.form-pagging').querySelector('[name="page"]');
                const elPageAll = elPage.querySelectorAll('option');
                
                if(elPageAll){
                    elPageAll.forEach(el=>el.remove());
                }
                for(let i = 0; i<total;i++){
                    const opt = document.createElement('option');
                    opt.value = i;
                    opt.textContent = `${i+1} page`;
                    elPage.appendChild(opt);
                }
            }
            totalPrev = total;

            res.data.data.data.forEach(item=>{
                const { code, name, date_create, parent_id } = item;
                const template = document.querySelector('#table-data').querySelector('[data-template="item"]').cloneNode(true);
                template.setAttribute('data-template','item-cloned');
                template.classList.remove('d-none');
                template.querySelector('[data-post="code"]').textContent = code;
                template.querySelector('[data-post="name"]').textContent = name;
                template.querySelector('[data-post="parent"]').textContent = parent_id;
                template.querySelector('[data-post="date_create"]').textContent = date_create;
                document.querySelector('#table-data').querySelector('tbody').appendChild(template);
            })
        }
    })
}















document.addEventListener('onload', search());