import { Outlet } from "react-router-dom";
import Header from "../header/Header";

export default function Layout() {
    return (
        <div>
            <Header />
            <main className="p-4">
                {/* Outlet pour rendre les composants enfants des routes */}
                <Outlet />
            </main>
        </div>
    );
}
