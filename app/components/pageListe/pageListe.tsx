import { useEffect, useState } from "react";
import axios from "axios";
import CardList from "~/components/CardList/cardList";

export default function PageListe() {
    const [shoppingLists, setShoppingLists] = useState([]);

    useEffect(() => {
        // Récupérer les listes depuis l'API
        axios.get("http://127.0.0.1:5556/liste/all")
            .then(response => {
                setShoppingLists(response.data);
            })
            .catch(error => {
                console.error("Erreur lors de la récupération des listes :", error);
            });
    }, []);

    // Fonction pour supprimer une liste après une suppression réussie via l'API
    const handleDelete = (id) => {
        setShoppingLists(prevLists => prevLists.filter(list => list.id !== id));
    };

    return (
        <section className="flex flex-wrap justify-between gap-2 p-4 max-w-6xl mx-auto mt-10">
            {shoppingLists.map(list => (
                <CardList key={list.id} shoppingList={list} onDelete={handleDelete} />
            ))}
        </section>
    );
}
