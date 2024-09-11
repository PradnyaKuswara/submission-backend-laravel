@extends('layouts.auth')
@section('title', 'Login Page')

@section('content')
    <div class="w-full animate__animated animate__fadeInLeft" x-data="loginPage">
        <div class="grid md:grid-cols-12">
            <div class="bg-white shadow-lg rounded-lg px-10 pt-8 pb-10  md:col-span-6">
                <h1 class="text-3xl  md:text-5xl font-sans  font-extrabold mb-4">Welcome Back !</h1>
                <h3 class="text-md md:text-xl ">Please insert your detail!</h3>
                <form x-ref="form-create" @submit.prevent="login()">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-xs md:text-sm font-bold mb-2" for="username">
                            Email
                        </label>
                        <input
                            class="shadow text-xs md:text-sm appearance-none border rounded w-4/5 md:w-10/12 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="email" type="text" name="email" placeholder="Email" autocomplete="off"
                            x-model="formData.email">
                        <template x-if="errorMessages.email">
                            <p class="text-xs mt text-red-700" x-text="errorMessages.email"></p>
                        </template>

                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-xs  md:text-sm font-bold mb-2" for="password">
                            Password
                        </label>
                        <input type="password"
                            class="shadow text-xs md:text-sm appearance-none border  rounded w-3/5  md:w-10/12 py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="password" name="password" type="password" placeholder="password"
                            x-model="formData.password">
                        <span class="border rounded py-2 px-3 " id="basic-addon1" onclick=""><i class="fa fa-eye-slash"
                                onclick="change(this);myFunction(); "></i></span>
                        <template x-if="errorMessages.password">
                            <p class="text-xs mt text-red-700" x-text="errorMessages.password"></p>
                        </template>
                    </div>
                    <div class="mb-6">
                        <button
                            class="bg-teal-900 w-full text-xs md:text-sm md:w-10/12 hover:opacity-75 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline"
                            type="submit">
                            Sign In
                        </button>
                    </div>
                    <div class="mb-6 ">
                        <a class="text-right font-bold text-xs md:text-sm text-blue-500 hover:underline hover:text-blue-800"
                            href="{{ route('register-page') }}">
                            Don't Have an Account?
                        </a>
                    </div>
                </form>
            </div>
            <div class="md:col-span-6 md:flex animate__animated animate__fadeIn">
                <img class="rounded-lg drop-shadow-lg" src="{{ asset('assets/images/1.jpg') }}" alt="">
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('loginPage', () => ({
                init() {},
                formData: {
                    email: '',
                    password: ''
                },

                errorMessages: {
                    email: '',
                    password: ''
                },

                login() {
                    this.errorMessages = {
                        email: '',
                        password: ''
                    }

                    $.ajax({
                        url: "{{ route('login') }}",
                        type: 'POST',
                        data: {
                            email: this.formData.email,
                            password: this.formData.password
                        },
                    }).done((response) => {
                        localStorage.setItem('user', JSON.stringify(response.data))
                        this.message('success', response.message)
                        this.formData = {
                            email: '',
                            password: ''
                        }

                        window.location.href = "{{ route('index') }}"
                    }).fail((error) => {
                        if (error.status === 422) {
                            this.errorMessages = error.responseJSON.data
                        }

                        if (error.status === 401) {
                            this.message('error', error.responseJSON.message)
                        }

                        if (error.status === 500) {
                            this.message('error', error.responseJSON.message)
                        }
                    })
                },

                message(type, message) {
                    let notyf = new Notyf({
                        duration: 4000,
                        position: {
                            x: 'right',
                            y: 'top',
                        }
                    });

                    if (type === 'success') {
                        notyf.success(message)
                    }

                    if (type === 'error') {
                        notyf.error(message)
                    }
                }
            }))
        })
    </script>
    <script>
        function myFunction() {
            let x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        function change(x) {
            x.classList.toggle("fa-eye");
        }
    </script>
@endpush
