<?php
$title = '회원가입';
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/head.php';
?>
<div class="container">
    <h2 class="mt-3">회원가입</h2>
    <form action="signup_ok.php" method="POST" id="signup" class="pb-5">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="username" id="username" placeholder="username">
            <label for="username">username</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="userid" id="userid" placeholder="userid">
            <label for="userid">userid</label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" name="email" id="email" placeholder="email">
            <label for="email">email</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" name="passwd" id="passwd" placeholder="passwd">
            <label for="passwd">passwd</label>
        </div>
        <button class="btn btn-primary" type="button">회원가입</button>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded',()=>{
        $('#signup button').on('click',function(){         
            let userid = $('#userid').val();
            let email = $('#email').val();

            let data = {
                userid:userid,
                email:email
            }
            console.log(data);
            $.ajax({
                async:false,
                url:'signup_check.php',
                data:data,
                type:'POST',
                dataType:'json',
                success:function(returned_data){
                    if(Number(returned_data.cnt) > 0){
                        alert('아이디 또는 이메일이 중복됩니다, 다시 시도해주세요.');
                        $('#userid').focus();
                        return false;
                    }else{
                        $('#signup').submit();
                    }
                }
            });
        });

    });//DOMContentLoaded
</script>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/pinkping/inc/tail.php';
?>