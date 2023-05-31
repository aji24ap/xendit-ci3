const alertMessage = document.querySelector('#info-my');
if(alertMessage){
    Swal.fire({
        icon    :  'info',
        title   :  '<strong>INFO</strong>',
        html    :  'Script ini dibuat oleh <a href="https://www.instagram.com/ajilh24/">Ilham Wahyu Aji</a>.',
        timer: 7700
    })
}