@extends('layouts.app')

@section('name', 'Manage Blog')

@section('content')
    <div class="max-w-screen-xl mx-auto pt-28 pb-52 p-5" x-data="manageBlogPage">
        <div>
            <h1 class="sans text-xl text-extrabold animate__animated animate__fadeInDown">Manage Blog</h1>
        </div>

        <div class="mt-4 relative overflow-x-auto shadow-lg sm:rounded-lg animate__animated animate__fadeIn">
            <div class="my-4">
                <a href="#"
                    class="md:float-right text-xs md:text-sm mb-4 py-2 px-3 bg-teal-900 text-white hover:opacity-75  font-medium text-center border border-gray-300 rounded-lg  focus:ring-4 focus:ring-gray-100">
                    <i class="fas fa-plus"></i> Create New Category
                </a>
            </div>

            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="border-b text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 border-r">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3 border-r">
                            Thumbail
                        </th>
                        <th scope="col" class="px-6 py-3 border-r">
                            title
                        </th>
                        <th scope="col" class="px-6 py-3 border-r">
                            Category
                        </th>
                        <th scope="col" class="px-6 py-3 border-r">
                            Author
                        </th>
                        <th scope="col" class="px-6 py-3 border-r">
                            Content
                        </th>
                        <th scope="col" class="px-6 py-3 border-r">
                            Created At
                        </th>
                        <th scope="col" class="px-6 py-3 border-r">
                            Updated At
                        </th>

                        <th scope="col" class="px-6 py-3">
                            <span class="">Action</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {{-- template alpine --}}
                    <template x-for="blog in dataBlogs.data" :key="blog.uuid">
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 border-r" x-text="blog.uuid">
                            </td>
                            <td class="px-6 py-4 border-r">
                                <img :src="blog.thumbnail" alt="thumbnail" class="w-20 h-20 object-cover">
                            </td>
                            <td class="px-6 py-4 border-r" x-text="blog.title">
                            </td>
                            <td class="px-6 py-4 border-r" x-text="blog.category.name">
                            </td>
                            <td class="px-6 py-4 border-r" x-text="blog.user.name">
                            </td>
                            <td class="px-6 py-4 border-r" x-text="contentLimit(blog.content)">
                            </td>
                            <td class="px-6 py-4 border-r" x-text="dateFormat(blog.created_at)">
                            </td>
                            <td class="px-6 py-4 border-r" x-text="dateFormat(blog.updated_at)">
                            </td>
                            <td class="px-6 py-4 flex ">
                                <a :href="`/manage-blog/${blog.id}/edit`" class="font-medium text-green-600 mr-2">
                                    <i class="fas fa-pencil"></i>
                                </a>
                                <form @submit.prevent="deleteBlog(blog.id)" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-600  hover:underline"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>

            {{-- pagination --}}
            <div class="flex justify-center mt-10">
                <template x-if="dataBlogs.pagination.prev_page_url">
                    <btn @click="fetchData(dataBlogs.pagination.prev_page_url)"
                        class="btn bg-primary text-primary-content mr-2">
                        Previous</btn>
                </template>
                <template x-if="!dataBlogs.pagination.prev_page_url">
                    <btn disabled class="btn bg-primary text-primary-content mr-2">
                        Previous</btn>
                </template>

                <template x-if="dataBlogs.pagination.next_page_url">
                    <btn @click="fetchData(dataBlogs.pagination.next_page_url)" class="btn bg-primary text-primary-content">
                        Next
                    </btn>
                </template>

                <template x-if="!dataBlogs.pagination.next_page_url">
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
            Alpine.data('manageBlogPage', () => ({
                init() {
                    this.fetchData('{{ route('posts.index') }}')
                },
                user: JSON.parse(localStorage.getItem('user')),
                dataBlogs: {
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

                        this.dataBlogs = {
                            data: response.data.data,
                            pagination: response.data.pagination
                        }

                        console.log(response)
                    }).fail((error) => {
                        console.log(error)
                    })
                },

                deleteData(uuid) {
                    $.ajax({
                        url: `{{ route('posts.index') }}/${uuid}`,
                        method: 'DELETE',
                        headers: {
                            Authorization: `Bearer ${this.user.token}`
                        }
                    }).done((response) => {
                        this.fetchData('{{ route('posts.index') }}')
                    }).fail((error) => {
                        console.log(error)
                    })
                },

                contentLimit(content) {
                    return content.substring(0, 50) + '...'
                },

                dateFormat(date) {
                    return new Date(date).toLocaleDateString('en-GB', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    })
                }
            }))
        })
    </script>
@endpush
