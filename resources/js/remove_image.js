function removeImage(userId, type)
            {
                if (confirm(`Are you sure you want to delete this ${type} image?`))
                {
                    $.ajax({
                        url: `/profile/remove${type}image/${userId}`,
                        type: 'POST',
                        data:
                        {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function(response)
                        {
                            location.reload();
                        },
                        error: function(xhr, status, error)
                        {
                            alert('An error occurred: ' + error);
                        }
                    });
                }
            }
            window.removeImage = removeImage;
