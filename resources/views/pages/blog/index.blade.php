@extends('layouts.app')

@section('title', 'Blogs')

@section('content')
    <section id="blogs" x-data="Blogs">
        <div class="container mx-auto pt-10 lg:pt-10" x-ref="blog-section">
            <div class="flex flex-col justify-center items-center gap-8">
                <div class="w-full px-4">
                    <div class="section-title mb-10">
                        <h2 class="text-3xl font-bold text-dark dark:text-white">Blogs</h2>
                        <p class="text-base text-body-color dark:text-dark-6">
                            All blogs from our blog.
                        </p>
                    </div>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                        <template x-for="blog in blogs.data" :key="blog.uuid">
                            <a :href="`/blogs/${blog.slug}`">
                                <div class="card rounded-none shadow-md h-full">
                                    <figure style=" border: 2px solid rgb(219, 219, 219);" class="aspect-video">
                                        <img :src="blog.thumbnail" alt="blog" class="w-full h-full object-contain " />
                                    </figure>

                                    <div class="flex flex-col gap-2 p-6">
                                        <div class="flex">
                                            <div class="badge badge-accent badge-outline">
                                                <span x-text="blog.category.name"></span>
                                            </div>
                                        </div>
                                        <div class="flex flex-col">
                                            <h3 class="text-lg font-semibold text-dark dark:text-white" x-text="blog.title">
                                            </h3>
                                            <p class="text-base text-body-color dark:text-dark-6"
                                                x-text="contentLimit(blog.content)">
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-xs text-base-300" x-text="dateFormat(blog.created_at)"></p>
                                            <p class="text-xs text-base-300" x-text="blog.user.name"></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </template>
                    </div>

                    {{-- pagination --}}
                    <div class="flex justify-center mt-10">
                        <template x-if="blogs.pagination.prev_page_url">
                            <btn @click="fetchBlogs(blogs.pagination.prev_page_url)"
                                class="btn bg-primary text-primary-content mr-2">
                                Previous</btn>
                        </template>
                        <template x-if="!blogs.pagination.prev_page_url">
                            <btn disabled class="btn bg-primary text-primary-content mr-2">
                                Previous</btn>
                        </template>

                        <template x-if="blogs.pagination.next_page_url">
                            <btn @click="fetchBlogs(blogs.pagination.next_page_url)"
                                class="btn bg-primary text-primary-content">Next
                            </btn>
                        </template>

                        <template x-if="!blogs.pagination.next_page_url">
                            <btn disabled class="btn bg-primary text-primary-content">Next
                            </btn>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('Blogs', () => ({
                blogs: [],
                init() {
                    this.fetchBlogs('{{ route('posts-frontend.index') }}');
                },
                fetchBlogs(url) {
                    $.ajax({
                        url: url,
                        method: 'GET',
                    }).done(response => {
                        this.blogs = response.data;

                        this.$refs['blog-section'].scrollIntoView({
                            behavior: 'smooth',
                            block: 'start',
                        });
                    }).fail(error => {
                        console.log(error);
                    });
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
            }));
        });
    </script>
@endpush
