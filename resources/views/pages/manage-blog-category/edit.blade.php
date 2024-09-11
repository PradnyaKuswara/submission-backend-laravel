@extends('layouts.app')

@section('title', 'Edit Blog Category')


@section('content')

    <div class="max-w-screen-xl mx-auto pt-28 pb-52 p-5" x-data="editBlogCategoryPage">
        <div>
            <h1 class="sans text-xl text-extrabold animate__animated animate__fadeInDown">Edit Blog Category</h1>
        </div>

        <div class="mt-4 relative overflow-x-auto shadow-lg sm:rounded-lg animate__animated animate__fadeIn">
            <form @submit.prevent="updateCategory()">
                <div class="my-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
                    <input type="text" name="name" id="name" x-model="formData.name"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    <template x-if="errorMessages.name">
                        <p class="text-xs mt-2 text-red-700" x-text="errorMessages.name"></p>
                    </template>
                </div>
                <div class="my-4">
                    <button type="submit"
                        class="bg-teal-900 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline">Update
                        Category</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('editBlogCategoryPage', () => ({
                formData: {
                    name: '{{ $postCategory->name }}',
                },

                errorMessages: {
                    name: '',
                },

                user: JSON.parse(localStorage.getItem('user')),
                updateCategory() {
                    this.errorMessages = {
                        name: '',
                    };
                    $.ajax({
                        url: '{{ route('post-categories.update', $postCategory->uuid) }}',
                        type: 'PATCH',
                        headers: {
                            Authorization: 'Bearer ' + this.user.token,
                        },
                        data: this.formData,

                    }).done((response) => {
                        this.message('success', response.message);

                        setTimeout(() => {
                            window.location.href =
                                '{{ route('manage.blogs.category.index') }}';
                        }, 1000);
                    }).fail((error) => {
                        if (error.status === 422) {
                            this.errorMessages = error.responseJSON.data;
                        }
                    });
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

            }));
        });
    </script>
@endpush
