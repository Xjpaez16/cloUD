<!-- Header -->
<header class="flex flex-col sm:flex-row justify-between items-center px-6 py-1 text-white" style="background-color: #803CB9;">
    <div >
    <img src="<?= BASE_URL ?>public/img/logo.png" alt="Logo cloUD" class="h-12 sm:h-14 lg:h-16 xl:h-20 pl-5">
</div>
    <nav class="flex space-x-4 sm:space-x-10 lg:space-x-32 xl:space-x-80 mt-3 sm:mt-0 font-semibold font-sans">
    <ul class="transition-transform duration-300 hover:scale-110 text-center transition-all duration-200" ><a href="<?= BASE_URL ?>index.php?url=RouteController/materials" class="text-[15px] lg:text-[20px] xl:text-[25px] text-center custom-underline">Gestiona Materiales Académicos</a></ul>
    <ul class="transition-transform duration-300 hover:scale-110 text-center transition-all duration-200"><a href="#" class="text-[15px] lg:text-[20px] xl:text-[25px] text-center custom-underline">Agenda Tutorías</a></ul>
    <ul class="transition-transform duration-300 hover:scale-110 text-center transition-all duration-200"><a href="#" class="text-[15px] lg:text-[20px] xl:text-[25px] text-center custom-underline">FAQ</a></ul>
    </nav>
    <div>
    <ul><a href="#">
        <img src="<?= BASE_URL ?>public/img/login.png" alt="Logo login" class="h-12 sm:h-14">
    </a></ul>
    </div>
</header>