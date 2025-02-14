import { type RouteConfig, index, prefix, route, layout } from "@react-router/dev/routes";

export default [
    // Route principale
    index("./routes/home.tsx"),

    ...prefix("lists", [
        layout("components/Layout/Layout.tsx", [
            // Routes imbriquées sous 'perso'
            route("add", "./routes/addLists.tsx"),
            route("all", "./routes/allLists.tsx"),
        ]),
    ])
] satisfies RouteConfig;
