<!-- NAV -->
<nav class="bg-[#803cb9] font-semibold font-sans">
    <script src="https://unpkg.com/flowbite@latest/dist/flowbite.min.js"></script>

    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="<?= BASE_URL ?>index.php?url=RouteController/student" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="<?= BASE_URL ?>public/img/logo.png" class="h-14 xl:h-24 lg:h-16" alt="cloud Logo" />
        </a>
        <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            <a href="<?= BASE_URL ?>index.php?url=RouteController/login">
                <img src="<?= BASE_URL ?>public/img/login.png" alt="login logo"
                    class="h-14 xl:h-32 lg:h-16 hover:scale-105 transition-transform duration-300" />
            </a>
            <button data-collapse-toggle="navbar-cta" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm  rounded-lg md:hidden  focus:outline-none focus:ring-2"
                aria-controls="navbar-cta" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-cta">
            <ul
                class="flex flex-col font-medium p-4 md:p-0 mt-4  rounded-lg  md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0  text-[15px] lg:text-[20px] xl:text-[25px] text-center ">

                <li>
                    <a href="#"
                        class="block py-2 px-3 md:p-0  rounded-sm  custom-underline dark:border-gray-700 text-[15px] lg:text-[20px] xl:text-[25px] text-center custom-underline">Recursos</a>
                </li>
                <li>
                    <a href="#"
                        class="block py-2 px-3 md:p-0  rounded-sm  custom-underline dark:border-gray-700 text-[15px] lg:text-[20px] xl:text-[25px] text-center custom-underline">Usuario</a>
                </li>
                <li>
                    <a href="#"
                        class="block py-2 px-3 md:p-0  rounded-sm  custom-underline dark:border-gray-700 text-[15px] lg:text-[20px] xl:text-[25px] text-center custom-underline">Tutorías</a>
                </li>
                <li>
                    <a href="#"
                        class="block py-2 px-3 md:p-0  rounded-sm  custom-underline dark:border-gray-700 text-[15px] lg:text-[20px] xl:text-[25px] text-center custom-underline">FAQ</a>
                </li>
            </ul>
        </div>
    </div>
</nav>