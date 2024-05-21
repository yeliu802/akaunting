<x-layouts.auth>
    <x-slot name="title">
        {{ trans('auth.register_user') }}
    </x-slot>

    <x-slot name="content">
        <div>
            <img src="{{ asset('public/img/akaunting-logo-green.svg') }}" class="w-16" alt="Akaunting" />

            <h1 class="text-lg my-3">
                Company Register
                {{-- {{ trans('auth.register_user') }} --}}
            </h1>
        </div>

        <div :class="(form.response.success) ? 'w-full bg-green-100 text-green-600 p-3 rounded-sm font-semibold text-xs' : 'hidden'"
            v-if="form.response.success"
            v-html="form.response.message"
            v-cloak
        ></div>

        <div :class="(form.response.error) ? 'w-full bg-red-100 text-red-600 p-3 rounded-sm font-semibold text-xs' : 'hidden'"
            v-if="form.response.error"
            v-html="form.response.message"
            v-cloak
        ></div>

        <x-form id="auth" route="signup.store">
            <div class="grid sm:grid-cols-6 gap-x-8 gap-y-6 my-3.5 lg:h-64">

                <x-form.group.text name="company_name" label="{{ trans('install.settings.company_name') }}" value="{{ old('company_name') }}" form-group-class="sm:col-span-6" />

                {{-- <x-form.group.text name="company_email" label="{{ trans('install.settings.company_email') }}" value="{{ old('company_email') }}" form-group-class="sm:col-span-6" /> --}}

                <x-form.group.text name="user_email" label="{{ trans('install.settings.admin_email') }}" value="{{ old('user_email') }}" form-group-class="sm:col-span-6" />

                <x-form.group.password
                    name="password"
                    label="{{ trans('auth.password.pass') }}"
                    placeholder="{{ trans('auth.password.pass') }}"
                    form-group-class="sm:col-span-6"
                    input-group-class="input-group-alternative"
                />

                <x-form.group.password
                    name="password_confirmation"
                    label="{{ trans('auth.password.pass_confirm') }}"
                    placeholder="{{ trans('auth.password.pass') }}"
                    form-group-class="sm:col-span-6"
                    input-group-class="input-group-alternative"
                />

                <x-button
                    type="submit"
                    ::disabled="form.loading"
                    class="relative flex items-center justify-center bg-green hover:bg-green-700 text-white px-6 py-1.5 text-base rounded-lg disabled:bg-green-100 sm:col-span-6"
                    override="class"
                    data-loading-text="{{ trans('general.loading') }}"
                >
                    <i v-if="form.loading" class="submit-spin absolute w-2 h-2 rounded-full left-0 right-0 -top-3.5 m-auto"></i>
                    <span :class="[{'opacity-0': form.loading}]">
                        {{ trans('auth.register') }}
                    </span>
                </x-button>

                <div class="sm:col-span-6 flex flex-row justify-between items-center">
                    <div></div>
                    @stack('login-from-signup-start')
                    <x-link href="{{ route('login') }}" class="text-black-400 hover:text-black-700 text-sm" override="class">
                        {{ trans('Already registerted? Login here.') }}
                    </x-link>
                    @stack('login-from-signup-end')
                </div>
            </div>
        </x-form>
    </x-slot>

    <x-script folder="auth" file="common" />
</x-layouts.auth>
