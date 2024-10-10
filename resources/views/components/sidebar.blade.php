<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:08
 */
?>
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="/">SID</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="/">SI</a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-desktop"></i><span>{{ __('site.dashboard') }}</span>
                </a>
            </li>
            @if(auth()->user()->can('view_roles') or auth()->user()->can('view_permissions'))
            <li class="nav-item dropdown {{ (Request::is('roles') or Request::is('permissions')) ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-user-cog"></i><span>{{ __('site.role_permission') }}</span>
                </a>
                <ul class="dropdown-menu">
                    @can('view_roles')
                    <li class="{{ Request::is('roles') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('roles') }}">
                            <i class="fas fa-user-ninja"></i><span>{{ __('site.role') }}</span>
                        </a>
                    </li>
                    @endcan
                    @can('view_permissions')
                    <li class="{{ Request::is('permissions') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('permissions') }}">
                            <i class="fas fa-user-lock"></i><span>{{ __('site.permission') }}</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endif
            <li class="menu-header">Menu</li>
            @if(
                auth()->user()->can('view_data_agama') or
                auth()->user()->can('view_data_akseptor_kb') or
                auth()->user()->can('view_data_asuransi') or
                auth()->user()->can('view_data_bahasa') or
                auth()->user()->can('view_data_cacat') or
                auth()->user()->can('view_data_golongan_darah') or
                auth()->user()->can('view_data_hubungan_keluarga') or
                auth()->user()->can('view_data_jabatan') or
                auth()->user()->can('view_data_jenis_persalinan') or
                auth()->user()->can('view_data_kawin') or
                auth()->user()->can('view_data_kursus') or
                auth()->user()->can('view_data_pekerjaan') or
                auth()->user()->can('view_data_pendidikan') or
                auth()->user()->can('view_data_penolong_kelahiran') or
                auth()->user()->can('view_data_sakit_menahun') or
                auth()->user()->can('view_data_status_dasar') or
                auth()->user()->can('view_data_suku') or
                auth()->user()->can('view_data_tempat_dilahirkan') or
                auth()->user()->can('view_data_warganegara')
            )
            <li class="nav-item dropdown 
                {{
                    (
                        Request::is('data-agamas') or
                        Request::is('data-akseptor-kbs') or
                        Request::is('data-asuransis') or
                        Request::is('data-bahasas') or
                        Request::is('data-cacats') or
                        Request::is('data-golongan-darahs') or
                        Request::is('data-hubungan-keluargas') or
                        Request::is('data-jabatans') or
                        Request::is('data-jenis-persalinans') or
                        Request::is('data-kawins') or
                        Request::is('data-kursuses') or
                        Request::is('data-pekerjaans') or
                        Request::is('data-pendidikans') or
                        Request::is('data-penolong-kelahirans') or
                        Request::is('data-sakit-menahuns') or
                        Request::is('data-status-dasars') or
                        Request::is('data-sukus') or
                        Request::is('data-tempat-dilahirkans') or
                        Request::is('data-warganegaras')
                    ) ? 'active' : ''
                }}
            ">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cubes"></i><span>{{ __('master_datas') }}</span></a>
                <ul class="dropdown-menu">
                    @can('view_data_agama')
                    <li class="{{ Request::is('data-agamas') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('data-agamas') }}"><span>{{ __('data_agama') }}</span></a>
                    </li>
                    @endcan
                    @can('view_data_akseptor_kb')
                    <li class="{{ Request::is('data-akseptor-kbs') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('data-akseptor-kbs') }}"><span>{{ __('data_akseptor_kb') }}</span></a>
                    </li>
                    @endcan
                    @can('view_data_asuransi')
                    <li class="{{ Request::is('data-asuransis') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('data-asuransis') }}"><span>{{ __('data_asuransi') }}</span></a>
                    </li>
                    @endcan
                    @can('view_data_bahasa')
                    <li class="{{ Request::is('data-bahasas') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('data-bahasas') }}"><span>{{ __('data_bahasa') }}</span></a>
                    </li>
                    @endcan
                    @can('view_data_cacat')
                    <li class="{{ Request::is('data-cacats') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('data-cacats') }}"><span>{{ __('data_cacat') }}</span></a>
                    </li>
                    @endcan
                    @can('view_data_golongan_darah')
                    <li class="{{ Request::is('data-golongan-darahs') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('data-golongan-darahs') }}"><span>{{ __('data_golongan_darah') }}</span></a>
                    </li>
                    @endcan
                    @can('view_data_hubungan_keluarga')
                    <li class="{{ Request::is('data-hubungan-keluargas') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('data-hubungan-keluargas') }}"><span>{{ __('data_hubungan_keluarga') }}</span></a>
                    </li>
                    @endcan
                    @can('view_data_jabatan')
                    <li class="{{ Request::is('data-jabatans') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('data-jabatans') }}"><span>{{ __('data_jabatan') }}</span></a>
                    </li>
                    @endcan
                    @can('view_data_jenis_persalinan')
                    <li class="{{ Request::is('data-jenis-persalinans') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('data-jenis-persalinans') }}"><span>{{ __('data_jenis_persalinan') }}</span></a>
                    </li>
                    @endcan
                    @can('view_data_kawin')
                    <li class="{{ Request::is('data-kawins') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('data-kawins') }}"><span>{{ __('data_kawin') }}</span></a>
                    </li>
                    @endcan
                    @can('view_data_kursus')
                    <li class="{{ Request::is('data-kursuses') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('data-kursuses') }}"><span>{{ __('data_kursus') }}</span></a>
                    </li>
                    @endcan
                    @can('view_data_pekerjaan')
                    <li class="{{ Request::is('data-pekerjaans') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('data-pekerjaans') }}"><span>{{ __('data_pekerjaan') }}</span></a>
                    </li>
                    @endcan
                    @can('view_data_pendidikan')
                    <li class="{{ Request::is('data-pendidikans') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('data-pendidikans') }}"><span>{{ __('data_pendidikan') }}</span></a>
                    </li>
                    @endcan
                    @can('view_data_penolong_kelahiran')
                    <li class="{{ Request::is('data-penolong-kelahirans') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('data-penolong-kelahirans') }}"><span>{{ __('data_penolong_kelahiran') }}</span></a>
                    </li>
                    @endcan
                    @can('view_data_sakit_menahun')
                    <li class="{{ Request::is('data-sakit-menahuns') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('data-sakit-menahuns') }}"><span>{{ __('data_sakit_menahun') }}</span></a>
                    </li>
                    @endcan
                    @can('view_data_status_dasar')
                    <li class="{{ Request::is('data-status-dasars') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('data-status-dasars') }}"><span>{{ __('data_status_dasar') }}</span></a>
                    </li>
                    @endcan
                    @can('view_data_suku')
                    <li class="{{ Request::is('data-sukus') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('data-sukus') }}"><span>{{ __('data_suku') }}</span></a>
                    </li>
                    @endcan
                    @can('view_data_tempat_dilahirkan')
                    <li class="{{ Request::is('data-tempat-dilahirkans') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('data-tempat-dilahirkans') }}"><span>{{ __('data_tempat_dilahirkan') }}</span></a>
                    </li>
                    @endcan
                    @can('view_data_warganegara')
                    <li class="{{ Request::is('data-warganegaras') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('data-warganegaras') }}"><span>{{ __('data_warganegara') }}</span></a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endif
            @can('view_kelahiran')
            <li class="{{ Request::is('kelahirans') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('kelahirans') }}">
                    <i class="fas fa-sliders-h"></i> <span>{{ __('kelahiran') }}</span>
                </a>
            </li>
            @endcan
            @can('view_keuangan')
            <li class="{{ Request::is('keuangans') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('keuangans') }}">
                    <i class="fas fa-copy"></i> <span>{{ __('keuangan') }}</span>
                </a>
            </li>
            @endcan
            @can('view_penduduk')
            <li class="{{ Request::is('penduduks') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('penduduks') }}">
                    <i class="fas fa-chart-pie"></i> <span>{{ __('penduduk') }}</span>
                </a>
            </li>
            @endcan
            @can('view_perangkat')
            <li class="{{ Request::is('perangkats') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('perangkats') }}">
                    <i class="fas fa-folder-open"></i> <span>{{ __('perangkat') }}</span>
                </a>
            </li>
            @endcan
            @can('view_users')
            <li class="{{ Request::is('users') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('users') }}">
                    <i class="fas fa-users"></i> <span>{{ __('users') }}</span>
                </a>
            </li>
            @endcan
        </ul>
    </aside>
</div>