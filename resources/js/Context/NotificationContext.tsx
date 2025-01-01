import { createContext, ReactNode, useContext, useState } from 'react';

// Define the shape of the context
interface NotificationContextType {
    showNotification: boolean;
    notificationMessage: string;
    notificationTitle: string;
    notificationColor: string;
    triggerNotification: (
        title: string,
        message: string,
        color: string,
    ) => void;
}

// Create the context with a default value of `undefined`
const NotificationContext = createContext<NotificationContextType | undefined>(
    undefined,
);

// Provider component
export const NotificationProvider = ({ children }: { children: ReactNode }) => {
    const [showNotification, setShowNotification] = useState(false);
    const [notificationMessage, setNotificationMessage] = useState('');
    const [notificationTitle, setNotificationTitle] = useState('');
    const [notificationColor, setNotificationColor] = useState('');

    const triggerNotification = (
        title: string,
        message: string,
        color: string,
    ) => {
        setNotificationMessage(message);
        setNotificationTitle(title);
        setNotificationColor(color);
        setShowNotification(true);
        setTimeout(() => setShowNotification(false), 2500); // Hide after 2.5 seconds
    };

    return (
        <NotificationContext.Provider
            value={{
                showNotification,
                notificationMessage,
                notificationTitle,
                notificationColor,
                triggerNotification,
            }}
        >
            {children}
        </NotificationContext.Provider>
    );
};

// Custom hook to use the Notification context
export const useNotification = () => {
    const context = useContext(NotificationContext);
    if (!context) {
        throw new Error(
            'useNotification must be used within a NotificationProvider',
        );
    }
    return context;
};
