import { Outlet } from "react-router-dom";
import Header from "../header/Header";
import Footer from "../Footer/Footer";

export default function Layout() {
    return (
        <div>
            <Header />
            <main className="p-4 mb-12">
                <Outlet />
            </main>
            <Footer/>
        </div>
    );
}
