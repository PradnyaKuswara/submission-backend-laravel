@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <section id="hero">
        <!-- ====== Hero Section Start -->
        <div class=" bg-white dark:bg-dark lg:pt-10">
            <div class=" hero-content flex-col lg:flex-row mx-auto ">
                <div>
                    <h1
                        class="mb-5 text-4xl font-bold !leading-[1.208] text-dark dark:text-white sm:text-[42px] lg:text-[40px] xl:text-5xl">
                        "Unveiling Perspectives: A Glimpse into My Personal Blog"
                    </h1>
                    <p class="mb-8 max-w-[480px] text-base text-body-color dark:text-dark-6">
                        Exploring the World Through My Eyes: Journey Notes and Life Inspirations from My Perspective
                    </p>
                    <ul class="flex flex-wrap items-center">
                        <li>
                            <a href="{{ route('index') }}/#newest-blog"
                                class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-center text-white rounded-md bg-primary hover:bg-blue-dark lg:px-7">
                                Get Started
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <img src="https://cdn.tailgrids.com/2.0/image/marketing/images/hero/hero-image-01.png" alt="hero"
                        class="max-w-full" />
                </div>
            </div>
        </div>
        <!-- ====== Hero Section End -->
    </section>

    <section id="newest-blog" x-data="newestBlog">
        <div class="container mx-auto pt-10 lg:pt-10 ">
            <div class="flex flex-col justify-center items-center gap-8">
                <div class="w-full px-4">
                    <div class="section-title mb-10">
                        <h2 class="text-3xl font-bold text-dark dark:text-white">Newest Blog</h2>
                        <p class="text-base text-body-color dark:text-dark-6">
                            The latest blog from our blog.
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
                </div>

                <div>
                    <a href="{{ route('blogs.index') }}" class="btn bg-primary text-primary-content ">
                        View All Blog
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('newestBlog', () => ({
                init() {
                    this.fetchBlogs()
                },
                blogs: [],

                fetchBlogs() {
                    $.ajax({
                        url: '{{ route('posts-frontend.newest') }}',
                        method: 'GET',
                    }).done((response) => {
                        this.blogs = response.data

                        console.log(this.blogs)
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
