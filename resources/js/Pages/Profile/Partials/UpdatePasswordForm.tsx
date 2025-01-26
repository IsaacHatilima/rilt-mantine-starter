import { useForm, usePage } from '@inertiajs/react';
import { Button, PasswordInput } from '@mantine/core';
import { useDisclosure } from '@mantine/hooks';
import { FormEventHandler, useRef } from 'react';

export default function UpdatePasswordForm() {
    const passwordInput = useRef<HTMLInputElement>(null);
    const currentPasswordInput = useRef<HTMLInputElement>(null);
    const [loading, { open, close }] = useDisclosure();
    const social_auth = usePage().props.auth.social_auth;

    const { data, setData, errors, put, reset } = useForm({
        current_password: '',
        password: '',
        password_confirmation: '',
    });

    const updatePassword: FormEventHandler = (e) => {
        e.preventDefault();
        open();

        put(route('password.update'), {
            preserveScroll: true,
            onSuccess: () => reset(),
            onError: (errors) => {
                if (errors.password) {
                    reset('password', 'password_confirmation');
                    passwordInput.current?.focus();
                }

                if (errors.current_password) {
                    reset('current_password');
                    currentPasswordInput.current?.focus();
                }
            },
            onFinish: () => {
                close();
            },
        });
    };

    return (
        <section>
            <header>
                <h2 className="text-lg font-medium">Update Password</h2>

                <p className="mt-1 text-sm">
                    Ensure your account is using a long, random password to stay
                    secure.
                </p>
            </header>

            <form onSubmit={updatePassword} className="mt-6 space-y-6">
                {!social_auth && (
                    <PasswordInput
                        id="current_password"
                        type="password"
                        name="current_password"
                        value={data.current_password}
                        error={errors.current_password}
                        autoComplete="current_password"
                        mt="md"
                        label="Current Password"
                        placeholder="Current Password"
                        onChange={(e) =>
                            setData('current_password', e.target.value)
                        }
                        inputWrapperOrder={[
                            'label',
                            'input',
                            'description',
                            'error',
                        ]}
                    />
                )}

                <PasswordInput
                    id="password"
                    type="password"
                    name="password"
                    value={data.password}
                    error={errors.password}
                    autoComplete="password"
                    mt="md"
                    label="Password"
                    placeholder="Password"
                    onChange={(e) => setData('password', e.target.value)}
                    inputWrapperOrder={[
                        'label',
                        'input',
                        'description',
                        'error',
                    ]}
                />

                <PasswordInput
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    value={data.password_confirmation}
                    error={errors.password_confirmation}
                    autoComplete="password_confirmation"
                    mt="md"
                    label="Password Confirmation"
                    placeholder="Password Confirmation"
                    onChange={(e) =>
                        setData('password_confirmation', e.target.value)
                    }
                    inputWrapperOrder={[
                        'label',
                        'input',
                        'description',
                        'error',
                    ]}
                />

                <div className="flex justify-end">
                    <Button
                        type="submit"
                        variant="filled"
                        color="black"
                        loading={loading}
                        loaderProps={{ type: 'dots' }}
                    >
                        Save
                    </Button>
                </div>
            </form>
        </section>
    );
}
