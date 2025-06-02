<div class="flex flex-col gap-5 xl:grid xl:grid-cols-8 mt-10">
    <div
        class="flex flex-col justify-between items-center col-start-1 col-span-2 bg-white rounded-lg p-4 shadow-2x border shadow-xl">
        <div>
            <svg width="400" height="200" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <circle cx="12" cy="9" r="3" stroke="#000000" stroke-width="1.5"></circle>
                    <circle cx="12" cy="12" r="10" stroke="#000000" stroke-width="1.5"></circle>
                    <path d="M17.9691 20C17.81 17.1085 16.9247 15 11.9999 15C7.07521 15 6.18991 17.1085 6.03076 20"
                        stroke="#000000" stroke-width="1.5" stroke-linecap="round"></path>
                </g>
            </svg>
        </div>
        <p class="font-medium">{{ auth()->user()->name }}</p>
        <p class="font-medium">{{ auth()->user()->getRoleNames()->first() }}</p>
        <p class="font-medium">{{ auth()->user()->email }}</p>
    </div>
</div>
