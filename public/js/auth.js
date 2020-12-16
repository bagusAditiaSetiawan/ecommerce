const authorization = () =>{
    axios.get(`${baseApi}/v1/users/current`,config).then(res=>{
        if(res.data.data.length <= 0){
            Toastify({
                text: `${res.data.message}`,
                backgroundColor: "red",
                className: "block",
              }).showToast();
              window.location.href = baseUrl+'/administrator/login';
        }
    })
}
authorization();