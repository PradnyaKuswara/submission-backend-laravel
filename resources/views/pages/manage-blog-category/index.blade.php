@extends('layouts.app')

@section('title', 'Manage Blog Category')

@section('content')
    <div class="max-w-screen-xl mx-auto pt-28 pb-52 p-5" x-data="manageBlogCategoryPage">
        <div>
            <h1 class="sans text-xl text-extrabold animate__animated animate__fadeInDown">Manage Blog Category</h1>
        </div>

        <div class="mt-4 relative overflow-x-auto shadow-lg sm:rounded-lg animate__animated animate__fadeIn">
            <div class="my-4">
                <a href="{{ route('manage.blogs.category.create') }}"
                    class="md:float-right text-xs md:text-sm mb-4 py-2 px-3 bg-teal-900 text-white hover:opacity-75  font-medium text-center border border-gray-300 rounded-lg  focus:ring-4 focus:ring-gray-100">
                    <i class="fas fa-plus"></i> Create New Blog
                </a>
            </div>

            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="border-b text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 border-r">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3 border-r">
                            Category Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="">Action</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {{-- template alpine --}}
                    <template x-for="category in dataCategories.data" :key="category.uuid">
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 border-r" x-text="category.uuid">
                            </td>
                            <td class="px-6 py-4 border-r" x-text="category.name">
                            </td>
                            <td class="px-6 py-4 flex ">
                                <a :href="`/manage/blog/category/edit/${category.uuid}`"
                                    class="font-medium text-green-600 mr-2">
                                    <i class="fas fa-pencil"></i>
                                </a>
                                <button @click="deleteCategory(category.uuid)"
                                    class="font-medium text-red-600  hover:underline"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>

            {{-- pagination --}}
            <div class="flex justify-center mt-10">
                <template x-if="dataCategories.pagination.prev_page_url">
                    <btn @click="fetchData(dataCategories.pagination.prev_page_url)"
                        class="btn bg-primary text-primary-content mr-2">
                        Previous</btn>
                </template>
                <template x-if="!dataCategories.pagination.prev_page_url">
                    <btn disabled class="btn bg-primary text-primary-content mr-2">
                        Previous</btn>
                </template>

                <template x-if="dataCategories.pagination.next_page_url">
                    <btn @click="fetchData(dataCategories.pagination.next_page_url)"
                        class="btn bg-primary text-primary-content">Next
                    </btn>
                </template>

                <template x-if="!dataCategories.pagination.next_page_url">
                    <btn disabled class="btn bg-primary text-primary-content">Next
                    </btn>
                </template>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('manageBlogCategoryPage', () => ({
                init() {
                    this.fetchData('{{ route('post-categories.index') }}')
                },
                user: JSON.parse(localStorage.getItem('user')),
                dataCategories: {
                    data: [],
                    pagination: {}
                },

                fetchData(url) {
                    $.ajax({
                        url: url,
                        method: 'GET',
                        headers: {
                            Authorization: `Bearer ${this.user.token}`
                        }
                    }).done((response) => {

                        this.dataCategories = {
                            data: response.data.data,
                            pagination: response.data.pagination
                        }

                        console.log(response)
                    }).fail((error) => {
                        console.log(error)
                    })
                },

                deleteCategory(uuid) {
                    $.ajax({
                        url: `{{ url('api/post-categories') }}/${uuid}`,
                        method: 'DELETE',
                        headers: {
                            Authorization: `Bearer ${this.user.token}`
                        }
                    }).done((response) => {
                        this.message('success', response.message)
                        this.fetchData('{{ route('post-categories.index') }}')
                    }).fail((error) => {
                        if (error.status === 401) {
                            this.message('error', error.responseJSON.message)
                        }

                        if (error.status === 500) {
                            this.message('error', error.responseJSON.message)
                        }

                        if (error.status === 404) {
                            this.message('error', error.responseJSON.message)
                        }

                        if (error.status === 400) {
                            this.message('error', 'Bad Request')
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
