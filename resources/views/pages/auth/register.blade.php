@extends('layouts.auth')

@section('title-page')
    Register Page
@endsection

@section('content')
    <div class="w-full" x-data="registerPage">
        <div class="grid md:grid-cols-12">
            <div class="bg-white shadow-lg rounded-lg px-10 pt-8 pb-10 md:col-span-12">
                <h1 class="text-2xl md:text-5xl font-sans  font-extrabold mb-4">Create Account</h1>
                <h3 class="text-md md:text-xl ">Please insert your detail!</h3>
                <form @submit.prevent="register()">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-xs md:text-sm font-bold mb-2" for="name">
                            Name
                        </label>
                        <input
                            class="shadow text-xs md:text-sm appearance-none border rounded w-4/5 md:w-10/12 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="name" type="text" name="name" placeholder="Name" autocomplete="off"
                            x-model="formData.name">
                        <template x-if="errorMessages.name">
                            <p class="text-xs mt-2 text-red-700" x-text="errorMessages.name"></p>
                        </template>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-xs md:text-sm font-bold mb-2" for="email">
                            Email
                        </label>
                        <input
                            class="shadow text-xs md:text-sm appearance-none border rounded w-4/5 md:w-10/12 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="email" type="text" name="email" placeholder="Email" autocomplete="off"
                            x-model="formData.email">

                        <template x-if="errorMessages.email">
                            <p class="text-xs mt-2 text-red-700" x-text="errorMessages.email"></p>
                        </template>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-xs  md:text-sm font-bold mb-2" for="password">
                            Password
                        </label>
                        <input type="password"
                            class="shadow text-xs md:text-sm appearance-none border  rounded w-3/5  md:w-10/12 py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="password" name="password" type="password" placeholder="password"
                            x-model="formData.password">

                        <template x-if="errorMessages.password">
                            <p class="text-xs mt-2 text-red-700" x-text="errorMessages.password"></p>
                        </template>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-xs  md:text-sm font-bold mb-2" for="password_confirmation">
                            Password Confirmation
                        </label>
                        <input type="password"
                            class="shadow text-xs md:text-sm appearance-none border  rounded w-3/5  md:w-10/12 py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                            id="password_confirmation" name="password" type="password" placeholder="password"
                            x-model="formData.password_confirmation">

                        <template x-if="errorMessages.password_confirmation">
                            <p class="text-xs mt-2 text-red-700" x-text="errorMessages.password_confirmation"></p>
                        </template>
                    </div>
                    <div class="mb-6">
                        <button
                            class="bg-teal-900 w-full text-xs md:text-sm md:w-10/12 hover:opacity-75 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline"
                            type="submit">
                            Register
                        </button>
                    </div>
                    <div class="mb-6 ">
                        <a class="text-right font-bold text-xs md:text-sm hover:underline text-blue-500 hover:text-blue-800"
                            href="{{ route('login-page') }}">
                            Already have an account?
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('registerPage', () => ({
                init() {},

                formData: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                },

                errorMessages: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                },

                register() {
                    this.errorMessages = {
                        name: '',
                        email: '',
                        password: '',
                        password_confirmation: ''
                    }

                    $.ajax({
                        url: "{{ route('register') }}",
                        type: 'POST',
                        data: this.formData,
                    }).done(response => {
                        this.message('success', response.message)
                        this.formData = {
                            name: '',
                            email: '',
                            password: '',
                            password_confirmation: ''
                        }
                        setTimeout(() => {
                            window.location.href = "{{ route('login-page') }}"
                        }, 2000)
                    }).fail(error => {
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
@endpush
