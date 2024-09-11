<!-- ====== Navbar Section Start -->
<header x-data="navbarPage" class="flex items-center w-full bg-white dark:bg-dark">
    <div class="container mx-auto">
        <div class="navbar bg-base-100">
            <div class="flex-1">
                <a class="btn btn-ghost lg:text-xl">Kuswara's Blog</a>
            </div>
            <div class="flex-none">
                <ul class="menu menu-horizontal px-1">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li><a href="{{ route('blogs.index') }}">Blog</a></li>

                    <template x-if="!user">
                        <li>
                            <ul class="flex gap-2">
                                <li><a href="{{ route('login-page') }}"
                                        class="btn btn-primary btn-outline btn-sm">Login</a></li>
                                <li><a href="{{ route('register-page') }}" class="btn btn-primary btn-sm">Register</a>
                                </li>
                            </ul>
                        </li>

                    </template>


                    <template x-if="user">
                        <li>
                            <div tabindex="0" role="button" class="dropdown dropdown-end">
                                <div class="flex gap-2">
                                    <summary>Manage</summary>
                                    <div><i class="fas fa-chevron-down fa-1x text-gray-400"></i></div>
                                </div>

                                <ul tabindex="0"
                                    class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-32 w-52 p-2 shadow">
                                    <li><a href="{{ route('manage.blogs.index') }}">Manage Blog</a></li>
                                    <li><a href="{{ route('manage.blogs.category.index') }}">Manage Blog Category</a>
                                    </li>
                                    <li><button @click="logout()">Logout</button></li>
                                </ul>
                            </div>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </div>
</header>
<!-- ====== Navbar Section End -->

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('navbarPage', () => ({
                init() {
                    this.user = JSON.parse(localStorage.getItem('user'))
                },
                navbarOpen: false,
                user: null,

                logout() {
                    $.ajax({
                        url: "{{ route('logout') }}",
                        type: 'POST',
                        headers: {
                            Authorization: `Bearer ${this.user.token}`
                        },
                    }).done(res => {
                        localStorage.removeItem('user')
                        this.user = null

                        window.location.href = '/'
                    }).fail(err => {
                        console.log(localStorage.getItem('token'))
                    })

                }
            }))
        })
    </script>
@endpush
