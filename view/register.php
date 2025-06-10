
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Tailwind CSS vía CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative min-h-screen bg-cover bg-bottom bg-no-repeat text-white font-sans"
    style="background-image: url('<?= BASE_URL ?>public/img/cloudfondo.jpg');">

    <div>
        <div class="min-h-screen flex flex-col items-center justify-center py-6 px-4">
            <div class="max-w-[480px] w-full">
                <a href="<?= BASE_URL ?>RouteController/index"><img src="<?= BASE_URL ?>public/img/logo.png" alt="logo"
                        class="w-40 mb-8 mx-auto block" />
                </a>

                <div class="p-6 sm:p-8 rounded-2xl bg-white border border-gray-200 shadow-sm font-sans">
                    <h1 class="text-slate-900 text-center text-3xl font-bold xl:text-5xl">Registrarse</h1>
                   
                        <div>
                            <label class="text-slate-900 text-sm mb-2 block xl:text-3xl text-center font-semibold">
                                Seleccione Rol
                            </label>
                            <div class="flex items-center">
                                <a href="<?= BASE_URL ?>RegisterController/role?role=estudiante" class="pl-20 pr-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="#803cb9" class="size-16 xl:size-28">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                                    </svg>
                                </a>
                                <label class="text-slate-900 text-sm font-bold mb-2 block xl:text-2xl ml-2">
                                    Estudiante
                                </label>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <a href="<?= BASE_URL ?>RegisterController/role?role=tutor" class="pl-20 pr-5">
                                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 494.004 494.004"
                                    xml:space="preserve" fill="#000000" class="size-16 xl:size-28">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <g>
                                            <g>
                                                <path style="fill:#803cb9;"
                                                    d="M291.266,85.984c23.74,0,42.984-19.252,42.984-42.992C334.25,19.243,315.006,0,291.266,0 c-23.738,0-43,19.243-43,42.992C248.266,66.732,267.527,85.984,291.266,85.984z">
                                                </path>
                                                <path style="fill:#803cb9;"
                                                    d="M335.481,93.288h-23.516l-20.707,33.887l-20.621-33.887h-24.48c0,0-56.627-0.741-60.728,48.108 l0.002,0.008v6.382l-22.121-15.117l-2.584-1.8c-4.726-3.668-8.234-5.134-12.886-5.34L104.377,11.422l-7.459,2.842l42.811,112.395 c-2.222,0.878-4.29,2.162-6.082,3.971c-7.442,7.391-7.27,19.545,0.259,27.073c0.034,0.035,12.283,8.33,12.283,8.33l17.107,11.431 l32.526,21.664c2.18,1.345,5.353,2.204,8.418,2.205l0.003,0.01c10.319,0,18.744-8.45,18.744-18.804c0-0.061,0-0.129,0-0.164 v-33.284h12.249l-0.035,80.107h112.618l-0.035-79.618h11.75v101.272h0.018c-0.018,0.285-0.018,0.621-0.018,0.836 c0,10.449,8.39,18.839,18.761,18.839c10.354,0,18.778-8.425,18.778-18.839c0-0.215-0.035-0.551-0.035-0.836h0.035V141.379 C397.089,141.379,399.362,94.468,335.481,93.288z M291.263,208.093l-12.421-63.277l12.421-15.875l14.229,15.875L291.263,208.093z">
                                                </path>
                                                <path style="fill:#803cb9;"
                                                    d="M234.932,242.514l-0.086,226.215c0,13.921,11.335,25.257,25.254,25.257 c13.868,0,25.083-11.164,25.29-24.963l0.188-0.189V262.723h11.336v205.904c0,13.988,11.389,25.377,25.396,25.377 c13.953,0,25.358-11.389,25.358-25.377L347.564,242.6L234.932,242.514z">
                                                </path>
                                                <rect x="280.387" y="232.298" style="fill:#803cb9;" width="21.742"
                                                    height="7.555"></rect>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </a>
                            <label class="text-slate-900 text-sm font-bold mb-2 block xl:text-2xl ml-2">
                                Tutor
                            </label>
                        </div>
                   
                </div>
            </div>
        </div>
    </div>
</body>

</html>