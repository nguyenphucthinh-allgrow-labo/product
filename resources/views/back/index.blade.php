@extends('back.layout.master')

@push('meta')
    <meta name="api-token" content="{{ auth()->user()->api_token }}">
@endpush

@prepend('pre-stylesheet')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.4.3/cropper.min.css" integrity="sha256-d2pK8EVd0fI3O9Y+/PYWrCfAZ9hyNvInLoUuD7qmWC8=" crossorigin="anonymous"/>
@endprepend

@section('body')
    <div id="app">
        <div v-if="false" class="common-loading-body">
            <div class="blob-body"></div>
        </div>
        <div class="d-flex" v-cloak>
            <b-sidebar
                id="main-sidebar"
                class="main-sidebar"
                :class="{active: sidebarState.active}"
                :sidebar-class="['bg-white', sidebarState.active ? 'active' : '', sidebarState.hovered ? 'hovered' : '']"
                text-variant="primary"
                no-close-on-backdrop
                no-header
                no-header-close
                shadow
            >
                <form id="logout-form" action="#" method="GET" style="display: none;">
                    @csrf
                </form>
                <div class="main-sidebar-logo position-relative bg-primary">
                    <b-img src="/images/logo.jpg" class="app-logo ml-3" :height="150" alt="App Logo"></b-img>
                    <button
                        class="close text-white"
                        @click="$store.commit('updateSidebarState', {active: !sidebarState.active})"
                    >
                        <f-chevrons-left-icon v-if="sidebarState.active"></f-chevrons-left-icon>
                        <f-chevrons-right-icon v-else></f-chevrons-right-icon>
                    </button>
                </div>
                <div
                    class="main-sidebar-menu bg-primary text-white"
                    @mouseover="$store.commit('updateSidebarState', {hovered: true})"
                    @mouseleave="$store.commit('updateSidebarState', {hovered: false})"
                >
                    <router-link
                        :to="{name: 'analytic'}"
                        class="no-decoration"
                        :class="{'router-link-exact-active': metaStack.module === 'analytic'}"
                    >
                        <div class="pl-default py-2 px-3">
                            <div class="div--navbar">
                                <f-bell-icon></f-bell-icon>
                                Thống kê
                            </div>
                        </div>
                    </router-link>

                    @if(Gate::allows('use-module-product-management'))
                        <router-link
                            :to="{name: 'product'}"
                            class="no-decoration"
                            :class="{'router-link-exact-active': metaStack.module === 'product'}"
                        >
                            <div class="pl-default py-2 px-3">
                                <div class="div--navbar">
                                    <f-list-icon></f-list-icon>
                                    Sản phẩm
                                    <i
                                        v-if="sidebarState.active"
                                        class="fa fa-caret-down i--dropdown"
                                        v-b-toggle.main-sidebar-product
                                    ></i>
                                </div>
                            </div>
                        </router-link>
                        <b-collapse
                            id="main-sidebar-product"
                            class="sub-menu-collapse"
                            :visible="metaStack.module === 'product' && (sidebarState.active || sidebarState.hovered)"
                        >
                            <ul class="bg-primary2">
                                <li class="mb-3">
                                    <router-link :to="{name: 'product'}" class="no-decoration">
                                        Danh sách sản phẩm
                                    </router-link>
                                </li>
                            </ul>
                        </b-collapse>
                    @endif
                </div>
            </b-sidebar>
            <div
                class="content-ctn flex-grow-1"
                :class="{'sidebar-deactive': !sidebarState.active, 'with-active-sidebar': sidebarState.active}"
            >
                <div class="content container-fluid">
                    <transition name="slide">
                        <router-view class="content__header" name="header"></router-view>
                        <router-view></router-view>
                        <router-view class="content__footer" name="footer"></router-view>
                    </transition>
                </div>
            </div>
        </div>
    </div>
@endsection

@prepend('body-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.min.js" integrity="sha256-EuV9YMxdV2Es4m9Q11L6t42ajVDj1x+6NZH4U1F+Jvw=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js" integrity="sha256-NXRS8qVcmZ3dOv3LziwznUHPegFhPZ1F/4inU7uC8h0=" crossorigin="anonymous"></script>
@endprepend

@prepend('app-scripts')
    <script src="{{ mix('/js/back/app.js') }}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAE7zocVnayiUt3EeLFosK0OaL9EYV46l8&callback=initGoogleSuccess&libraries=places"></script>
    <script type="text/javascript">
        function initGoogleSuccess() {
            $(document).trigger('initGoogleSuccess');
            $(document).data('initGoogleSuccess', true);
        }
    </script>
@endprepend
