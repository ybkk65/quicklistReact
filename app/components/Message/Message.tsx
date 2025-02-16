import React from "react";

interface MessageProps {
    type: "success" | "error";
    text: string;
}

const Message: React.FC<MessageProps> = ({ type, text }) => {
    return (
        <div className={`p-3 rounded-md text-white ${type === "success" ? "bg-green-500" : "bg-red-500"}`}>
            {text}
        </div>
    );
};

export default Message;
