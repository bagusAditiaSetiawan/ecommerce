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
                const { code, name, date_create, parent_id, id } = item;
                const template = document.querySelector('#table-data').querySelector('[data-template="item"]').cloneNode(true);
                template.setAttribute('data-template','item-cloned');
                template.classList.remove('d-none');
                template.querySelector('[data-post="code"]').textContent = code;
                template.querySelector('[data-post="name"]').textContent = name;
                template.querySelector('[data-post="parent"]').textContent = parent_id;
                template.querySelector('[data-post="date_create"]').textContent = date_create;                
                template.querySelector('[data-post="edit"]').setAttribute('onclick',`editHandler(${id})`);
                template.querySelector('[data-post="delete"]').setAttribute('onclick',`deleteHandler(${id})`);
                document.querySelector('#table-data').querySelector('tbody').appendChild(template);
            })
        }
    })
}

const formClear = () => {
    document.querySelector('.modal-form').querySelector('[name="id"]').value = '';
    document.querySelector('.modal-form').querySelector('[name="code"]').value = '';
    document.querySelector('.modal-form').querySelector('[name="name"]').value = '';
}


const initForm = () => {
    return new Promise((resolve, reject)=>{
        axios.get(`${baseApi}/v1/products/categories?parent_id=0`, config).then(res=>{
            const select = document.querySelector('.modal-form').querySelector('[name="parent_id"]');
            const deleteOptions = select.querySelectorAll('option');
            if(deleteOptions.length > 0){
                deleteOptions.forEach(el=>el.remove());
            }
            const opt = document.createElement('option');
            opt.value = 0;
            opt.textContent = 'As a Parent';
            select.appendChild(opt);
            if(res.data.data.data.length > 0){
                res.data.data.data.forEach(category=>{
                    const opt = document.createElement('option');
                    opt.value = category.id;
                    opt.textContent = category.name;
                    select.appendChild(opt);
                })
            }
            resolve(res)
        }).catch(e=>reject(e));
    })
}

const modalShow = () =>{
    formClear();
    return initForm().then(res=>{
        $('.modal-form').modal('show');
    })
}

const submitHandler = (event) => {
    event.preventDefault();
    let link;
    const id = document.querySelector('.modal-form').querySelector('[name="id"]').value;
    if(id > 0){
        link = `${baseApi}/v1/products/categories/update/${id}`
    }else{
        link = `${baseApi}/v1/products/categories/insert`
    }
    axios.post(link,new FormData(event.target),config).then(res=>{
        if(res.data.status === 400){
            const key = Object.keys(res.data.data)[0];
            Toastify({
                text: `${res.data.data[key]}`,
                backgroundColor: "red",
                className: "block",
              }).showToast();
        }else{
            formClear();
            search();            
            $('.modal-form').modal('hide');        
            Toastify({
                text: `${res.data.message}`,
                backgroundColor: "yellow",
                className: "success",
            }).showToast();
        }
    });
}

const editHandler=(id)=>{
    axios.get(`${baseApi}/v1/products/categories/show/${id}`, config).then(res=>{
        initForm().then(()=>{
            formClear();
            const { code, name, date_create, parent_id, id } = res.data.data;
            const form = document.querySelector('.modal-form');
            form.querySelector('[name="parent_id"]').value = parent_id;
            form.querySelector('[name="name"]').value = name;
            form.querySelector('[name="code"]').value = code;
            form.querySelector('[name="id"]').value = id;
        })
    }).then(()=>{
        $('.modal-form').modal('show');
    })
}

const deleteHandler=(id)=>{
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        reverseButtons: true
      }).then((result) => {
        if (result.value) {
            axios.get(`${baseApi}/v1/products/categories/delete/${id}`, config).then(res=>{
                search()           
                swal(
                    'Deleted!',
                    `${res.data.message}`,
                    'success'
                )
            });
        // result.dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        } else if (result.dismiss === 'cancel') {
          swal(
            'Cancelled',
            'Your imaginary file is safe :)',
            'error'
          )
        }
      })
}







document.addEventListener('onload', search());