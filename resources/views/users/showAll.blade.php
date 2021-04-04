@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Users</div>

                <div class="card-body">
                	<ul id="users">
                		
                	</ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@push('script')
<script>
	window.axios.get('/api/users')
	.then(response => {
		let users = response.data;
		const elementUser = document.getElementById('users');
		users.forEach((users, index) => {
			let listElement = document.createElement('li');
			listElement.setAttribute('id', users.id);
			listElement.innerText = users.name;
			elementUser.appendChild(listElement);
		});

	})
	.catch(error => {
		console.log(error);
	});
</script>

<script>
	Echo.channel('users')
        .listen('CreateUser', (e) => {
            const usersElement = document.getElementById('users');
            let element = document.createElement('li');
            element.setAttribute('id', e.user.id);
            element.innerText = e.user.name;
            usersElement.appendChild(element);
        })
        .listen('UpdateUser', (e) => {
            let element = document.getElementById(e.user.id);
            element.innerText = e.user.name;
        })
        .listen('DeleteUser', (e) => {
            let element = document.getElementById(e.user.id);
            element.parentNode.removeChild(element);
        });
</script>

@endpush