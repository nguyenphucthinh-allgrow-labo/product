import VueRouter from 'vue-router';
import MainHeader from "./component/MainHeader";
import MainContent from "./component/MainContent";
import Home from "./home/Home";
import Error404 from "./errors/404";
import ProductList from "./product/ProductList";
import ProductInfo from "./product/ProductInfo";

function prefixRoutes(prefix, routes) {
    return routes.map((route) => {
        route.path = `${prefix}/${route.path}`;
        return route;
    });
}

function getRouter(i18n, appConfig) {
    const routes = [
        {
            path: '/',
            component: MainContent,
            children: [
                {
                    path: '/',
                    name: 'home',
                    components: {default: Home, header: MainHeader},
                    props: {
                        header: {
                            title: i18n.t('home.title')
                        },
                    },
                    meta: {
                        module: 'home',
                    }
                },
            ],
            // redirect: '/dashboard'
        },
        {
            name: 'product',
            path: '/product',
            component: MainContent,
            redirect: { name: 'product.list'},
            children: [
                {
                    name: 'product.list',
                    path: 'list',
                    components: {default: ProductList, header: MainHeader},
                    meta: {
                        baseUrl: `${appConfig.baseApiUrl}/product`
                    }
                },
                {
                    path: ':productId/:action(create||edit||info)',
                    name: 'product.info',
                    components: {default: ProductInfo, header: MainHeader},
                    meta: {
                        baseUrl: `${appConfig.baseApiUrl}/product`,
                    },
                },
            ],
            meta: {
                module: 'product'
            }
        },
        {
            path: '/not-found',
            name: '404',
            component: Error404,
        },
        {
            path: '*',
            redirect: { name: '404' },
        }
    ];

    const router = new VueRouter({
        mode: 'history',
        base: '/back',
        routes
    });
    return router;
}

export default getRouter;
