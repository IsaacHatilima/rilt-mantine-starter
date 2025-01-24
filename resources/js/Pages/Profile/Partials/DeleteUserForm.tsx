import { useNotification } from '@/Context/NotificationContext';
import { useForm } from '@inertiajs/react';
import { Button, Modal, PasswordInput } from '@mantine/core';
import { useDisclosure } from '@mantine/hooks';
import { FormEvent, FormEventHandler, useRef } from 'react';

export default function DeleteUserForm({
    className = '',
}: {
    className?: string;
}) {
    const [loading, { open, close }] = useDisclosure(false);
    const { triggerNotification } = useNotification();
    const passwordInput = useRef<HTMLInputElement>(null);
    const [firstOpened, firstHandlers] = useDisclosure(false);

    const {
        data,
        setData,
        delete: destroy,
        processing,
        reset,
        errors,
    } = useForm({
        current_password: '',
    });

    const deleteUser: FormEventHandler = (e: FormEvent<Element>): void => {
        e.preventDefault();
        open();
        destroy(route('profile.destroy'), {
            preserveScroll: true,
            onSuccess: () => {
                triggerNotification(
                    'Success',
                    'Your profile has been updated successfully!',
                    'green',
                );
            },
            onError: () => passwordInput.current?.focus(),
            onFinish: () => {
                reset();
                close();
            },
        });
    };

    return (
        <section className={`space-y-6 ${className}`}>
            <header>
                <div className="mb-2 w-full rounded-md bg-red-600 p-3">
                    <h2 className="text-lg font-medium text-white">
                        Danger Zone
                    </h2>
                </div>

                <h2 className="text-lg font-medium">Delete Account</h2>

                <p className="mt-1 text-sm">
                    Once your account is deleted, all of its resources and data
                    will be permanently deleted. Before deleting your account,
                    please download any data or information that you wish to
                    retain.
                </p>
            </header>

            <div className="flex justify-end">
                <Button
                    onClick={() => {
                        firstHandlers.open();
                    }}
                    variant="filled"
                    color="red"
                >
                    Delete Account
                </Button>
            </div>

            <Modal
                opened={firstOpened}
                title="Account Deletion"
                onClose={() => {
                    firstHandlers.close();
                    reset();
                }}
            >
                <form onSubmit={deleteUser} className="p-6">
                    <h2 className="text-lg font-medium text-gray-900">
                        Are you sure you want to delete your account?
                    </h2>

                    <p className="mt-1 text-sm text-gray-600">
                        Once your account is deleted, all of its resources and
                        data will be permanently deleted. Please enter your
                        password to confirm you would like to permanently delete
                        your account.
                    </p>

                    <div className="mt-6">
                        <PasswordInput
                            id="current_password"
                            type="password"
                            name="current_password"
                            value={data.current_password}
                            error={errors.current_password}
                            autoComplete="password"
                            data-autofocus
                            mt="md"
                            label="Password"
                            placeholder="Password"
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
                    </div>

                    <div className="mt-6 flex justify-end">
                        <Button
                            onClick={() => {
                                reset();
                                firstHandlers.close();
                            }}
                        >
                            Cancel
                        </Button>

                        <Button
                            type="submit"
                            className="ms-3"
                            disabled={processing}
                            loading={loading}
                            loaderProps={{ type: 'dots' }}
                            variant="filled"
                            color="red"
                        >
                            Delete Account
                        </Button>
                    </div>
                </form>
            </Modal>
        </section>
    );
}
