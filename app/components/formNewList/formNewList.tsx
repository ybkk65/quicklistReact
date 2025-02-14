import React, { useState } from 'react';
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faX} from "@fortawesome/free-solid-svg-icons";
import { useNavigate } from 'react-router-dom';

const ShoppingListForm = () => {
    const [listName, setListName] = useState<string>('');
    const [items, setItems] = useState<{ name: string; quantity: number }[]>([]);
    const [newItem, setNewItem] = useState<{ name: string; quantity: number }>({ name: '', quantity: 0 });

    const handleAddItem = () => {
        if (newItem.name && newItem.quantity > 0) {
            setItems([...items, newItem]);
            setNewItem({ name: '', quantity: 0 });
        } else {
            alert('Veuillez entrer un nom de produit et une quantité valide');
        }
    };

    const handleRemoveItem = (index: number) => {
        const updatedItems = items.filter((_, i) => i !== index);
        setItems(updatedItems);
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();

        const data = {
            name: listName,
            items: items
        };

        fetch('http://127.0.0.1:5556/liste/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(data => {
                if (data.message === "Liste ajoutée avec succès") {
                    alert('Liste ajoutée avec succès!');
                } else {
                    alert('Erreur: ' + data.message);
                }
            })
            .catch(error => {
                alert('Erreur de connexion');
            });
    };

    return (
        <form onSubmit={handleSubmit} className="space-y-4 p-4 max-w-6xl mx-auto">
            {/* Titre de la liste */}
            <div>
                <label htmlFor="listName" className="block text-sm font-medium text-gray-700">
                    Nom de la liste
                </label>
                <input
                    id="listName"
                    type="text"
                    value={listName}
                    onChange={(e) => setListName(e.target.value)}
                    className="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                    placeholder="Entrez le nom de la liste"
                />
            </div>
            <div>
                <label className="block text-sm font-medium text-gray-700">Éléments</label>
                <div className="flex space-x-2">
                    <input
                        type="text"
                        value={newItem.name}
                        onChange={(e) => setNewItem({ ...newItem, name: e.target.value })}
                        className="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                        placeholder="Nom du produit"
                    />
                    <input
                        type="number"
                        value={newItem.quantity}
                        onChange={(e) => setNewItem({ ...newItem, quantity: Number(e.target.value) })}
                        className="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                        placeholder="Quantité"
                    />
                    <button
                        type="button"
                        onClick={handleAddItem}
                        className="mt-1 px-4 py-2 bg-blue-500 text-white rounded-md"
                    >
                        Ajouter
                    </button>
                </div>
            </div>
            <div className="space-y-2 flex gap-2 bg-gray-100 p-4 rounded-lg wrap ">
                {items.map((item, index) => (
                    <div key={index} >
                        <div className="p-2 flex items-center bg-gray-200  font-bold  rounded">
                        <span className={"mr-2"}> {item.quantity} - {item.name}</span>
                        <button
                            type="button"
                            onClick={() => handleRemoveItem(index)}
                            className="text-red-500  ml-3 text-sm p-1 bg-gray-300 rounded"
                        >
                            <FontAwesomeIcon icon={faX} />
                        </button>
                        </div>
                    </div>
                ))}
            </div>
            <button
                type="submit"
                className="w-full py-2 bg-green-500 text-white rounded-md"
            >
                Soumettre
            </button>
        </form>
    );
};

export default ShoppingListForm;
