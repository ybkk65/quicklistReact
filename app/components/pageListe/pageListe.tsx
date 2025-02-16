import { useEffect, useState } from "react";
import axios from "axios";
import CardList from "~/components/CardList/cardList";
import {faList} from "@fortawesome/free-solid-svg-icons";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";

export default function PageListe() {
    const [shoppingLists, setShoppingLists] = useState([]);

    useEffect(() => {
        axios.get("http://127.0.0.1:5556/liste/all")
            .then(response => {
                setShoppingLists(response.data);
            })
            .catch(error => {
                console.error("Erreur lors de la récupération des listes :", error);
            });
    }, []);

    const handleDelete = (id) => {
        setShoppingLists(prevLists => prevLists.filter(list => list.id !== id));
    };

    return (
        <section className=" p-4 max-w-6xl mx-auto ">
            <div className="flex gap-4 items-center mb-10">
                <FontAwesomeIcon className="text-2xl" icon={faList}/>
                <h2 className="font-black text-2xl uppercase flex items-center">Vos Listes</h2>
            </div>


            <div className={"flex flex-wrap justify-between gap-2"}>
                {shoppingLists.map(list => (
                    <CardList key={list.id} shoppingList={list} onDelete={handleDelete}/>
                ))}
            </div>
        </section>
    );
}
