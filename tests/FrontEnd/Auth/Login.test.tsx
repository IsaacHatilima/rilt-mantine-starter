import { useForm } from '@inertiajs/react';
import '@testing-library/jest-dom/vitest';
import { render, screen } from '@testing-library/react';
import userEvent from '@testing-library/user-event';
import React, { ComponentProps } from 'react';
import { beforeEach, describe, expect, it, vi } from 'vitest';
import Login from '../../../resources/js/Pages/Auth/Login';

vi.mock('@inertiajs/react', () => ({
    usePage: () => ({
        props: {
            socialAuth: { google: true },
        },
    }),
    useForm: vi.fn(),
    Link: ({ children, ...props }: ComponentProps<'a'>) => (
        <a {...props}>{children}</a>
    ),
    Head: ({ children, ...props }: { children: React.ReactNode }) => (
        <div {...props}>{children}</div>
    ),
}));

interface LoginFormData {
    email: string;
    password: string;
    remember: boolean;
}

interface UseFormReturn<TForm> {
    data: Partial<TForm>;
    setData: () => void;
    post: () => void;
    processing: boolean;
    errors: object;
    reset: () => void;
}

type MockedUseForm = typeof useForm & {
    mockReturnValue: (value: UseFormReturn<LoginFormData>) => void;
};

interface MockedLocation {
    href: string;
    assign: (url: string) => void;
}

describe('Login', () => {
    const mockPost = vi.fn();

    beforeEach(() => {
        vi.resetAllMocks();

        (global.window as { location: MockedLocation }).location = {
            href: 'http://localhost:3000/',
            assign: vi.fn(),
        };

        const mockedFormReturn: UseFormReturn<LoginFormData> = {
            data: {},
            setData: vi.fn(),
            post: mockPost,
            processing: false,
            errors: {},
            reset: vi.fn(),
        };

        (useForm as MockedUseForm).mockReturnValue(mockedFormReturn);
    });

    it('Should render login page', () => {
        render(<Login />);

        expect(
            screen.getByRole('checkbox', { name: /remember/i }),
        ).toBeInTheDocument();
        expect(
            screen.getByRole('button', { name: /Login/i }),
        ).toBeInTheDocument();
        expect(
            screen.getByText("Don't have an account? Register here"),
        ).toBeInTheDocument();
        expect(screen.getByText('Forgot your password?')).toBeInTheDocument();
        expect(screen.getByPlaceholderText(/E-Mail/i)).toBeInTheDocument();
        expect(screen.getByPlaceholderText(/Password/i)).toBeInTheDocument();
    });

    it('Should render login page with Google login', () => {
        render(<Login />);

        expect(
            screen.getByRole('checkbox', { name: /remember/i }),
        ).toBeInTheDocument();
        expect(
            screen.getByRole('button', { name: /Login/i }),
        ).toBeInTheDocument();
        expect(
            screen.getByRole('link', { name: /Continue with Google/i }),
        ).toBeInTheDocument();
        expect(
            screen.getByText("Don't have an account? Register here"),
        ).toBeInTheDocument();
        expect(screen.getByText('Forgot your password?')).toBeInTheDocument();
        expect(screen.getByPlaceholderText(/E-Mail/i)).toBeInTheDocument();
        expect(screen.getByPlaceholderText(/Password/i)).toBeInTheDocument();
    });

    it('Should allow user to login and call the post method with correct data', async () => {
        render(<Login />);

        const emailInput = screen.getByPlaceholderText(/E-Mail/i);
        const passwordInput = screen.getByPlaceholderText(/Password/i);
        const loginButton = screen.getByRole('button', { name: /Login/i });

        // Simulates form inputs
        await userEvent.type(emailInput, 'testuser@example.com');
        await userEvent.type(passwordInput, 'password123');

        // Assert input values
        expect(emailInput).toHaveValue('testuser@example.com');
        expect(passwordInput).toHaveValue('password123');

        // Simulates form submission to route /login
        await userEvent.click(loginButton);

        expect(mockPost).toHaveBeenCalledWith(
            '/login',
            expect.objectContaining({
                onFinish: expect.any(Function),
                onError: expect.any(Function),
            }),
        );
    });
});
