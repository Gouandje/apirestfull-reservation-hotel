update(hotel: Hotel) {
    this.http.put<Hotel>(`${this.baseUrl}/todos/${todo.id}`, JSON.stringify(todo))
      .subscribe(data => {
        this.dataStore.todos.forEach((t, i) => {
          if (t.id === data.id) { this.dataStore.todos[i] = data; }
        });

        this._todos.next(Object.assign({}, this.dataStore).todos);
      }, error => console.log('Could not update todo.'));
  }