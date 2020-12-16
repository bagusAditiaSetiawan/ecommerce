
const  handlerSubmit = (event) => {
    event.preventDefault();
    const formData = new FormData(event.target);
    axios.post(`${baseApi}/v1/users/login`, formData).then((res)=>{
        if(res.data.data.token){
            localStorage.setItem('token', res.data.data.token);
            window.location.href = `${baseUrl}/administrator/dashboard`
        }else{
            document.querySelector('.alert-danger').innerHtml = res.data.message;
            document.querySelector('.alert-danger').classList.remove('d-none');
        }
    }).catch(err=>{

    })
}

const config = {
    headers:{
        Authorization:`Bearer ${localStorage.getItem('token')}`
    }
}

const authorization = () =>{
    axios.get(`${baseApi}/v1/users/current`,config).then(res=>{
        if(Object.keys(res.data.data).length > 0){
            window.location.href = baseUrl+'/administrator/dashboard';
        }
    })
}
authorization();